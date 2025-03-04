<?php

class User {
    private Database $db;

    public function __construct(Database $db) {
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
        return $this->db->select("users LEFT JOIN rooms ON users.room_id = rooms.id", 
            ["users.*", "rooms.name AS room_name"]);
    }

    
    public function update($id, $name, $email, $room_id, $ext) {
        try {
            $sql = "UPDATE users SET name = :name, email = :email, room_id = :room_id, ext = :ext WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':room_id' => $room_id,
                ':ext' => $ext,
                ':id' => $id
            ]);
        } catch (PDOException $e) {
            die("Error updating user: " . $e->getMessage());
        }
    }

    public function delete($id) {
        return $this->db->delete("users", "id = ?", [$id]);
    }
}
?>
