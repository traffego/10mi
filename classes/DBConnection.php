<?php
if(!defined('DB_SERVER')){
    require_once("../initialize.php");
}
class DBConnection {

    private $host = DB_SERVER;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    
    public $conn;
    
    public function __construct() {

        if (!isset($this->conn)) {
            $this->connect();
        }
    }

    private function connect() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        $this->conn->set_charset("utf8mb4");
        
        if (!$this->conn) {
            echo 'Cannot connect to database server';
            exit;
        } 
    }

    public function reconnect() {
        if (!$this->conn->ping()) {
            $this->conn->close();
            $this->connect();
        }
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>