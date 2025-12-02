<?php
// controllers/AuthController.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../models/UserModel.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $db = new Database();
        $pdo = $db->connect();
        $this->userModel = new UserModel($pdo);
    }

    // Handle login
    public function login($username, $password) {
        $user = $this->userModel->authenticate($username, $password);

        if ($user) {
            // Start session and store user info
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];

            return $user; // return array on success
        } else {
            return false; // return false on failure
        }
    }

    // Handle signup
    public function signup($username, $password, $full_name = null) {
        if ($this->userModel->userExists($username)) {
            return "Username already exists.";
        }

        $created = $this->userModel->createUser($username, $password, $full_name, 0);
        if ($created) {
            return true; // Successful signup
        } else {
            return "Signup failed. Please try again.";
        }
    }

    // Handle logout
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_unset();
        session_destroy();
        header('Location: index.php?page=login_signup');
        exit();
    }

    // Check if user is logged in
    public static function checkAuth($requireAdmin = false) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?page=login_signup');
            exit();
        }

        if ($requireAdmin && (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1)) {
            header('Location: index.php?page=home');
            exit();
        }
    }
}
