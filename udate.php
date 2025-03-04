<?php
session_start();
include 'datebase.php';

if (!isset($_GET['id'])) {
    die("User ID is required!");
}

$id = $_GET['id'];
$user = select($pdo, "user", ["id", "name", "email", "room_id", "ext"], "id = ?", [$id])[0];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $room_id = $_POST['room_id'];
    $ext = trim($_POST['ext']);

    if (update_user($pdo, $id, $name, $email, $room_id, $ext)) {
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error updating user.";
    }
}
?>

<form method="post">
    <input type="text" name="name" value="<?= $user['name'] ?>" required>
    <input type="email" name="email" value="<?= $user['email'] ?>" required>
    <select name="room_id" required>
        <option value="">Select Room</option>
        <?php
        $rooms = get_all_rooms($pdo);
        foreach ($rooms as $room) {
            $selected = ($room['id'] == $user['room_id']) ? "selected" : "";
            echo "<option value='{$room['id']}' $selected>{$room['name']}</option>";
        }
        ?>
    </select>
    <input type="text" name="ext" value="<?= $user['ext'] ?>">
    <button type="submit">Update</button>
</form>

