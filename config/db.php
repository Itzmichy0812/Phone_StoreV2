<?php
// config/db.php

// --- PHẦN 1: Cấu hình chung ---
$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';          // Mặc định XAMPP là rỗng
$db_name = 'phone_shop';
$db_port = '3307';      // ⚠️ Lưu ý: XAMPP thường là 3306. Nếu máy bạn đổi cổng thì sửa thành 3307

// --- PHẦN 2: Kết nối MySQLi (Cho code cũ của Quân - Login/Register) ---
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

if ($conn->connect_error) {
    die("Kết nối MySQLi thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4"); // Hỗ trợ tiếng Việt

// --- PHẦN 3: Kết nối PDO (Cho code mới của Post - MVC) ---
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;
    public $conn;

    public function __construct() {
        // Lấy lại các biến cấu hình từ bên ngoài
        global $db_host, $db_name, $db_user, $db_pass, $db_port;
        $this->host = $db_host;
        $this->db_name = $db_name;
        $this->username = $db_user;
        $this->password = $db_pass;
        $this->port = $db_port;
    }

    public function connect() {
        $this->conn = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch(PDOException $e) {
            echo "Lỗi kết nối PDO: " . $e->getMessage();
            exit();
        }
        return $this->conn;
    }
}
?>