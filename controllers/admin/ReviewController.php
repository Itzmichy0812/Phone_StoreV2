<?php
// File: controllers/admin/ReviewController.php

// Check admin login (session already started in index.php)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: index.php?page=home');
    exit;
}

require_once 'config/db.php';
require_once 'models/ProductReviewModel.php';

$database = new Database();
$db = $database->connect();
$reviewModel = new ProductReviewModel($db);

// Get filter params
$status = $_GET['status'] ?? 'all';
$currentPage = isset($_GET['current_page']) ? (int)$_GET['current_page'] : 1;
$limit = 15;
$offset = ($currentPage - 1) * $limit;

// Get reviews with user and product info
$reviews = $reviewModel->getAllReviewsAdmin($status, $limit, $offset);
$totalReviews = $reviewModel->countReviewsByStatus($status);
$totalPages = ceil($totalReviews / $limit);

// Get review statistics
$stats = [
    'total' => $reviewModel->countReviewsByStatus('all'),
    'pending' => $reviewModel->countReviewsByStatus('pending'),
    'approved' => $reviewModel->countReviewsByStatus('approved'),
    'rejected' => $reviewModel->countReviewsByStatus('rejected')
];

// Load view
include 'views/admin/manage_reviews.php';
