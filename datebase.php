<?php
include_once 'config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


function insert($pdo, $table, $columns, $values) {
    $colNames = implode(", ", $columns);
    $placeholders = implode(", ", array_fill(0, count($values), "?"));
    $sql = "INSERT INTO $table ($colNames) VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($values);
}

function selectAll($pdo, $table) {
    $stmt = $pdo->query("SELECT * FROM $table");
    return $stmt->fetchAll();
}

function select($pdo, $table, $columns, $condition = "", $params = []) {
    $colNames = implode(", ", $columns);
    $sql = "SELECT $colNames FROM $table";
    if (!empty($condition)) {
        $sql .= " WHERE $condition";
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function update($pdo, $table, $columns, $values, $condition) {
    if (count($values) == count($columns)) {
        $setClause = implode(" = ?, ", $columns) . " = ?";
        $sql = "UPDATE $table SET $setClause WHERE $condition";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($values);
    } else {
        echo "Columns and values count mismatch.<br>";
        return false;
    }
}

function delete($pdo, $table, $condition, $params = []) {
    $sql = "DELETE FROM $table WHERE $condition";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}
?>

