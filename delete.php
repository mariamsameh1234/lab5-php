<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include 'config.php'; 
include 'datebase.php'; 
include 'user.php'; 

$db = new Database(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$userObj = new User($db);


if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
   
    if ($userObj->delete($userId)) {
        header("Location: display_users.php?success=User deleted successfully");
    } else {
        header("Location: display_users.php?error=Failed to delete user");
    }
    exit;
}
?>

