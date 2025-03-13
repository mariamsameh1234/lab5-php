<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include 'datebase.php';


$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$pdo = $db->getConnection(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $room_id = $_POST['room_id'];
    $ext = trim($_POST['ext']);
    $profile_picture = "";

    $errors = [];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($room_id)) {
        $errors[] = "All fields are required!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format!";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Password and confirmation do not match!";
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetchColumn() > 0) {
        $errors[] = "Email is already in use!";
    }

    if ($_FILES['profile_picture']['error'] !== 0) {
        $errors[] = "Profile picture is required!";
    } else {
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $file_ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);

        if (!in_array(strtolower($file_ext), $allowed_extensions)) {
            $errors[] = "Invalid file type! Only JPG, PNG, and GIF are allowed.";
        }

        if ($_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
            $errors[] = "File size must be less than 2MB!";
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
        exit;
    }

    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["profile_picture"]["name"]);
    $target_file = $upload_dir . $file_name;
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
    $profile_picture = $file_name;

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, room_id, ext, profile_picture) VALUES (?, ?, ?, ?, ?, ?)");

    try {
        $stmt->execute([$name, $email, $hashed_password, $room_id, $ext, $profile_picture]);
        header("Location: add_user.php?success=" . urlencode("User added successfully!"));
    } catch (PDOException $e) {
        header("Location: add_user.php?error=" . urlencode("Error inserting data: " . $e->getMessage()));
    }

    exit();
}
?>
