<?php
final class DatabaseConfig {
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $charset;

    public function __construct($host, $user, $pass, $dbname, $charset = "utf8mb4") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
        $this->charset = $charset;
    }

    public function getDsn() {
        return "mysql:host=$this->host;dbname=$this->dbname;charset=$this->charset";
    }

    public function getUser() {
        return $this->user;
    }

    public function getPass() {
        return $this->pass;
    }
}
?>
