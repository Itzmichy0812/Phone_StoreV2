<?php
require_once __DIR__ . '/../config/db.php';   

class ContactModel {

    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    // Save user contact info to db table
    public function create($name, $email, $subject, $message) {
        $sql = "INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $subject, $message]);
    }


    // Get all contacts
    public function getAll() {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single contact
    public function getById($id) {
        $sql = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update status (read, unread, replied)
    public function updateStatus($id, $status) {
        $sql = "UPDATE contacts SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $id]);
    }

    // Delete contact
    public function delete($id) {
        $sql = "DELETE FROM contacts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
