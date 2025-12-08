<?php
// File: controllers/admin/ReviewController.php

require_once 'config/db.php';
require_once 'models/ProductReviewModel.php';

class ReviewController {
    private $db;
    private $reviewModel;

    public function __construct() {
        // Kiểm tra quyền Admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
            header('Location: index.php?page=home');
            exit;
        }

        $database = new Database();
        $this->db = $database->connect();
        $this->reviewModel = new ProductReviewModel($this->db);
    }

    public function index() {
        // 1. Lấy tham số lọc
        $status = $_GET['status'] ?? 'all';
        $currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;
        $limit = 15;
        $offset = ($currentPage - 1) * $limit;

        // 2. Lấy dữ liệu từ Model
        $reviews = $this->reviewModel->getAllReviewsAdmin($status, $limit, $offset);
        $totalReviews = $this->reviewModel->countReviewsByStatus($status);
        $totalPages = ceil($totalReviews / $limit);

        // 3. Tính toán thống kê ($stats) - Đây là biến bạn đang thiếu
        $stats = [
            'total' => $this->reviewModel->countReviewsByStatus('all'),
            'pending' => $this->reviewModel->countReviewsByStatus('pending'),
            'approved' => $this->reviewModel->countReviewsByStatus('approved'),
            'rejected' => $this->reviewModel->countReviewsByStatus('rejected')
        ];

        // 4. Gửi dữ liệu sang View
        // Lưu ý: Đường dẫn này tính từ file index.php gốc
        include 'views/admin/manage_reviews.php';
    }
}