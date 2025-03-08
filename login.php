
<header>
    <link rel="stylesheet" href="style.css">
</header>

<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include 'datebase.php';
include 'user.php';


$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userObj = new User($db);


if (!isset($_GET['id']) && !isset($_POST['id'])) {
    die("User ID is required.");
}

$id = $_GET['id'] ?? $_POST['id'];
$user = $userObj->getUserById($id);

if (!$user) {
    die("User not found.");
}

$rooms = $userObj->getAllRooms();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $room_id = $_POST['room_id'] ?? '';
    $ext = $_POST['ext'] ?? '';

    if (empty($id) || empty($name) || empty($email) || empty($room_id)) {
        die("<p style='color:red;'> Please fill in all required fields.</p>");
    }

   
    $updated = $userObj->update($id, $name, $email, $room_id, $ext);

    if ($updated) {
        header("Location: display_users.php?success=User updated successfully");
        exit();
    } else {
        echo "<p style='color:red;'> Failed to update user. Please try again.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update User</title>
</head>
<body>
<h2>Update User</h2>

<?php if (isset($_GET['success'])) : ?>
    <p style="color:green;"><?= htmlspecialchars($_GET['success']) ?></p>
<?php elseif (isset($_GET['error'])) : ?>
    <p style="color:red;"><?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<form action="update_user.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

    <label>Room:</label>
    <select name="room_id" required>
        <?php foreach ($rooms as $room) : ?>
            <option value="<?= $room['id'] ?>" <?= ($room['id'] == $user['room_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($room['name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label>Ext:</label>
    <input type="text" name="ext" value="<?= htmlspecialchars($user['ext']) ?>">

    <button type="submit" name="update">Update</button>
</form>

<a href="display_users.php">Back to Users</a>

</body>
</html>
