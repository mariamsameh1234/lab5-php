<?php
require_once 'config.php';

class Database {
    private $pdo;
    public function __construct(DatabaseConfig $config) {
        try {
            $this->pdo = new PDO(
                $config->getDsn(),
                $config->getUser(),
                $config->getPass(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    
    public function getConnection() {
        return $this->pdo;
    }

    /
    public function insert($table, $columns, $values) {
        $colNames = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($values), "?"));
        $sql = "INSERT INTO $table ($colNames) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($values);
    }

    
    public function selectAll($table) {
        $stmt = $this->pdo->query("SELECT * FROM $table");
        return $stmt->fetchAll();
    }


    public function select($table, $columns, $condition = "", $params = []) {
        $colNames = implode(", ", $columns);
        $sql = "SELECT $colNames FROM $table";
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

   
    public function update($table, $columns, $values, $condition) {
        if (count($values) == count($columns)) {
            $setClause = implode(" = ?, ", $columns) . " = ?";
            $sql = "UPDATE $table SET $setClause WHERE $condition";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($values);
        } else {
            echo "Columns and values count mismatch.<br>";
            return false;
        }
    }

    public function delete($table, $condition, $params = []) {
        $sql = "DELETE FROM $table WHERE $condition";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
?>






