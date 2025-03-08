
<?php
class User {
    private $db;   

    public function __construct($db) {
        $this->db = $db;
    }

    public function insert($name, $email, $password, $room_id, $ext, $profile_picture) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $this->db->insert("users", ["name", "email", "password", "room_id", "ext", "profile_picture"], 
            [$name, $email, $hashed_password, $room_id, $ext, $profile_picture]);
    }

    public function getAllRooms() {
        return $this->db->selectAll("rooms");
    }

    public function getAll() {
        return $this->db->select(
            "users LEFT JOIN rooms ON users.room_id = rooms.id", 
            ["users.id", "users.name", "users.email", "rooms.name AS room_name"]
        );
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($id, $name, $email, $room_id, $ext) {
        $sql = "UPDATE users SET name = ?, email = ?, room_id = ?, ext = ? WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        return $stmt->execute([$name, $email, $room_id, $ext, $id]);
    }

    public function delete($id) {
        return $this->db->delete("users", "id = ?", [$id]);
    }
}
?>
