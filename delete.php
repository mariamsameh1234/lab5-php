<?php
session_start();
include 'database.php';


$config = new Config('localhost', 'root', 'rootroot', 'php');
$db = new Database($config);
$userObj = new User($db);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    delete_user($pdo, $id);
}

header("Location: display_users.php");
exit();

