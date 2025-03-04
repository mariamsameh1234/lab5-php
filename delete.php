<?php
session_start();
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    delete_user($pdo, $id);
}

header("Location: display_users.php");
exit();

