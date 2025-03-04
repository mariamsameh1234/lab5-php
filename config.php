
<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '123456');
define('DB_NAME', 'caffe');

class DatabaseConfig {
    private $host, $user, $pass, $dbname;

    public function __construct($host, $user, $pass, $dbname) {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    public function getDbHost() {
        return $this->host;
    }

    public function getUser() {
        return $this->user;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getDbName() {
        return $this->dbname;
    }
}
?>
