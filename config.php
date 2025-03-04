<?php
 final class DatabaseConfig{
    private $host;
    private $user;
    private $pass;
    private $dbname;

    public function __construct($host, $user, $pass, $dbname, $charset = "utf8mb4") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    public function getDatabase() {
        return "mysql:host=$this->host;dbname=$this->dbname;charset={$this->charset";
    }

    public function getUser() {
        return $this->user;
    }

    public function getPass() {
        return $this->pass;
    }
}

?>













?>


