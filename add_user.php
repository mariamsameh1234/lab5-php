<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php"); 
    exit();
}

include 'header.php';
include 'config.php';
include 'datebase.php';

$stmt = $pdo->query("SELECT id, name FROM rooms");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2>Add user</h2>
    <form action="validation.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder=" Name">
        <input type="email" name="email" required placeholder=" Email ">
        <input type="password" name="password" required placeholder=" Password">
        <input type="password" name="confirm_password" required placeholder=" Confirm Password">
        
        <select id="room_id" name="room_id" required>
            <option value="">Select a room</option>
            <?php foreach ($rooms as $room) : ?>
                <option value="<?= $room['id'] ?>"><?= htmlspecialchars($room['name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="ext" placeholder="Ext">
        <input type="file" name="profile_picture">
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
        <button type="button" onclick="window.location.href='display_users.php'">Display All Users</button>

    </form>
</div>

<?php include 'footer.php'; 


?>

