
<?php
require_once 'database.php';

class User {
    private Database $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

   
    public function insert($name, $email, $password, $room_id, $ext, $profile_picture) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->insert("user", ["name", "email", "password", "room_id", "ext", "profile_picture"], 
            [$name, $email, $hashed_password, $room_id, $ext, $profile_picture]);
    }

 
    public function getAllRooms() {
        return $this->db->selectAll("rooms");
    }


    public function getAll() {
        return $this->db->select("user LEFT JOIN rooms ON user.room_id = rooms.id", 
            ["user.*", "rooms.name AS room_name"]);
    }

   
    public function update($id, $name, $email, $room_id, $ext) {
        return $this->db->update("user", ["name", "email", "room_id", "ext"], 
            [$name, $email, $room_id, $ext, $id], "id = ?");
    }

   
    public function delete($id) {
        return $this->db->delete("user", "id = ?", [$id]);
    }
}
?>
