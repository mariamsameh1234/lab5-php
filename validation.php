<?php
session_start();
include 'config.php'; 
include 'datebase.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $room_id = $_POST['room_id'];
    $ext = trim($_POST['ext']);

  
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($room_id)) {
        die("Please fill all required fields.");
    }

 
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

   
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, room_id, ext) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, $room_id, $ext]);

        header("Location: display_users.php"); 
        exit();
    } catch (PDOException $e) {
        die("Error inserting user: " . $e->getMessage());
    }
}
?>

