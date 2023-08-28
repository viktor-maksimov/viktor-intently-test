<?php

namespace App\DB;

// Database class for establishing MySQL connection using mysqli
class Database {
    private $host = 'localhost';
    private $db_name = 'intently';
    private $username = 'root';
    private $password = '';
    private $port = 5455;
    
    public $conn;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->db_name, $this->port);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
}