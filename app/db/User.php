<?php

namespace App\DB;

use App\DB\Database;

// User class for handling user data
class User {
    private $db;
    private $table = 'not_so_smart_users';

    public function __construct(Database $db) {
        $this->db = $db->conn;
    }

    public function getAllUsers() {
        $result = $this->db->query("SELECT * FROM $this->table");

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
