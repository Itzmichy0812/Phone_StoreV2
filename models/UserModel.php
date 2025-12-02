<?php
// models/UserModel.php

class UserModel {
    private $conn;

    // Pass PDO connection via constructor
    public function __construct(PDO $db_conn) {
        $this->conn = $db_conn;
    }

    // Check if username exists
    public function userExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }

    // Create new user
    public function createUser($username, $password, $full_name = null, $is_admin = 0) {
        $stmt = $this->conn->prepare(
            "INSERT INTO users (username, password, full_name, is_admin) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), $full_name, $is_admin]);
    }

    // Authenticate user
    public function authenticate($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Check if user is admin
    public function isAdmin($username) {
        $stmt = $this->conn->prepare("SELECT is_admin FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch();
        return $result && $result['is_admin'] == 1;
    }
}
