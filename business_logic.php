
<?php
include_once 'database.php';

function insert_user($pdo, $name, $email, $password, $room_id, $ext, $profile_picture) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    return insert($pdo, "user", ["name", "email", "password", "room_id", "ext", "profile_picture"], [$name, $email, $hashed_password, $room_id, $ext, $profile_picture]);
}

function get_all_rooms($pdo) {
    return selectAll($pdo, "rooms");
}

function get_all_users($pdo) {
    return select($pdo, "user LEFT JOIN rooms ON user.room_id = rooms.id", ["user.*", "rooms.name AS room_name"], "", []);
}

function update_user($pdo, $id, $name, $email, $room_id, $ext) {
    return update($pdo, "user", ["name", "email", "room_id", "ext"], [$name, $email, $room_id, $ext, $id], "id = ?");
}

function delete_user($pdo, $id) {
    return delete($pdo, "user", "id = ?", [$id]);
}
?>

