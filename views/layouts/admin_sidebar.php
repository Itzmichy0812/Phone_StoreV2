<?php
// Determine active page
$currentPage = $_GET['page'] ?? 'admin_dashboard';
?>

<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-speedometer2"></i> Admin Panel</h4>
    </div>
    <nav class="sidebar-nav">
        <a href="?page=admin_dashboard" class="sidebar-link <?= $currentPage === 'admin_dashboard' ? 'active' : '' ?>">
            <i class="bi bi-grid"></i> Dashboard
        </a>
        <a href="?page=manage_products" class="sidebar-link <?= $currentPage === 'manage_products' ? 'active' : '' ?>">
            <i class="bi bi-box-seam"></i> Products
        </a>
        <a href="?page=manage_info" class="sidebar-link <?= $currentPage === 'manage_info' ? 'active' : '' ?>">
            <i class="bi bi-gear"></i> Site Information
        </a>
        <a href="?page=manage_contacts" class="sidebar-link <?= $currentPage === 'manage_contacts' ? 'active' : '' ?>">
            <i class="bi bi-envelope"></i> Customer Contacts
        </a>
        <a href="?page=manage_qna" class="sidebar-link <?= $currentPage === 'manage_qna' ? 'active' : '' ?>">
            <i class="bi bi-question-circle"></i> Q&A Management
        </a>
        <a href="?page=manage_about_info" class="sidebar-link <?= $currentPage === 'manage_about_info' ? 'active' : '' ?>">
            <i class="bi bi-info-circle"></i> About Page
        </a>
        <a href="?page=admin_reviews" class="sidebar-link <?= $currentPage === 'admin_reviews' ? 'active' : '' ?>">
            <i class="bi bi-star"></i> Reviews
        </a>
        <a href="?page=manage_orders" class="sidebar-link <?= $currentPage === 'manage_orders' ? 'active' : '' ?>">
            <i class="bi bi-cart"></i> Orders
        </a>
        <a href="?page=manage_posts" class="sidebar-link <?= $currentPage === 'manage_posts' ? 'active' : '' ?>">
            <i class="bi bi-file-text"></i> Posts
        </a>
        <a href="?page=manage_profile" class="sidebar-link <?= $currentPage === 'manage_profile' ? 'active' : '' ?>">
            <i class="bi bi-people"></i> Users
        </a>
    </nav>
</aside>
