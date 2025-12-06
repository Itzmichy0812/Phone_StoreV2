<?php
// Start session to access user info and cart count
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'models/CartModel.php';
$cartCount = CartModel::getItemCount();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhoneStore</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<header class="main-header">
    <div class="nav-container">
      <div class="nav-logo">
        <a href="index.php?page=home">
            <img src="assets/img/logo.png" alt="PhoneStore Logo">
        </a>
      </div>

      <nav class="nav-menu">
        <a href="index.php?page=home" class="nav-link">Home</a>
        <a href="index.php?page=shop" class="nav-link">Shop</a>
        <a href="index.php?page=post" class="nav-link">Post</a>
        <a href="index.php?page=about" class="nav-link">About</a>
        <a href="index.php?page=contact" class="nav-link">Contact</a>
        <a href="index.php?page=qna" class="nav-link">Q&A</a>
        
        <!-- Admin link visible only for admin -->
        <?php if ($isLoggedIn && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <a href="index.php?page=admin_dashboard" class="nav-link text-danger fw-bold">Admin</a>
        <?php endif; ?>

        <!-- Cart dropdown -->
        <div class="cart-dropdown-wrapper">
            <?php if (!$isLoggedIn): ?>
                <!-- Guest: clicking icon redirects to login -->
                <a href="index.php?page=login_signup" class="cart-icon-btn" 
                onclick="alert('You must log in to access the cart'); return true;">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-badge" id="cartBadge"><?= $cartCount ?></span>
                </a>
            <?php else: ?>
                <!-- Logged-in user: normal dropdown button -->
                <button class="cart-icon-btn" id="cartIconBtn" type="button">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-badge" id="cartBadge"><?= $cartCount ?></span>
                </button>
            <?php endif; ?>
            
            <div class="cart-dropdown" id="cartDropdown">
                <div class="cart-dropdown-header">
                    <h6>Shopping Cart</h6>
                    <span class="cart-item-count" id="cartItemCount"><?= $cartCount ?> items</span>
                </div>
                
                <div class="cart-dropdown-body" id="cartDropdownBody">
                    <div class="cart-empty-message">
                        <i class="bi bi-cart-x"></i>
                        <p>Your cart is empty</p>
                    </div>
                </div>
                
                <div class="cart-dropdown-footer">
                    <div class="cart-total">
                        <span>Total:</span>
                        <strong id="cartTotalAmount">0.00</strong>
                    </div>
                    <div class="cart-actions">
                        <a href="?page=cart" class="btn btn-outline">View Cart</a>
                        <a href="?page=checkout" class="btn btn-primary">Checkout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sign Up / Logout button -->
        <?php if ($isLoggedIn): ?>
            <a href="#" id="logout-btn" class="nav-link">Logout (<?= htmlspecialchars($username) ?>)</a>
        <?php else: ?>
            <a href="index.php?page=login_signup" class="nav-link nav-signup">Login</a>
        <?php endif; ?>
      </nav>
    </div>
</header>

<script src="assets/javascript/cart.js"></script>

<!-- Logout confirmation script -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            e.preventDefault();
            if (confirm("Are you sure you want to logout?")) {
                // Redirect to logout route
                window.location.href = "index.php?page=logout";
            }
        });
    }
});
</script>
