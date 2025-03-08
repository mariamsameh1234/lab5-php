

<header>
    <link rel="stylesheet" href="style.css">
</header>
<?php
session_start();

error_reporting(E_ALL);

ini_set('display_errors', 1);

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'header.php';
include 'config.php';
include 'datebase.php';
include 'user.php';

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userObj = new User($db);
$rooms = $userObj->getAllRooms();

?>

<div class="container">
    <h2>Add User</h2>

    <?php if (isset($_GET['success'])) : ?>
        <p style="color:green;"> <?= htmlspecialchars($_GET['success']) ?> </p>
    <?php elseif (isset($_GET['error'])) : ?>
        <p style="color:red;"> <?= htmlspecialchars($_GET['error']) ?> </p>
    <?php endif; ?>

    <form action="validation.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" required placeholder="Name">
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <input type="password" name="confirm_password" required placeholder="Confirm Password">
        
        <select id="room_id" name="room_id" required>
            <option value="">Select a room</option>
            <?php foreach ($rooms as $room) : ?>
                <option value="<?= $room['id'] ?>"> <?= htmlspecialchars($room['name']) ?> </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="ext" placeholder="Ext">
        <input type="file" name="profile_picture" required>
        
        <button type="submit">Submit</button>
        <button type="reset">Reset</button>
        <button type="button" onclick="window.location.href='display_users.php'">Display All Users</button>
    </form>
</div>

<?php include 'footer.php'; ?>
