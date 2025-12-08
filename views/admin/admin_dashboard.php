<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<?php 
include 'views/layouts/header.php'; 

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php?page=home");
    exit();
}

// Get database statistics
require_once 'config/db.php';
$database = new Database();
$pdo = $database->connect();

// Get stats
$stats = [];

// Total products
$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$stats['products'] = $stmt->fetch()['total'];

// Total orders
$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders");
$stats['orders'] = $stmt->fetch()['total'];

// Total revenue
$stmt = $pdo->query("SELECT SUM(total) as revenue FROM orders WHERE status = 'completed'");
$stats['revenue'] = $stmt->fetch()['revenue'] ?? 0;

// Pending orders
$stmt = $pdo->query("SELECT COUNT(*) as total FROM orders WHERE status = 'pending'");
$stats['pending_orders'] = $stmt->fetch()['total'];

// Unread contacts
$stmt = $pdo->query("SELECT COUNT(*) as total FROM contacts WHERE status = 'unread'");
$stats['unread_contacts'] = $stmt->fetch()['total'];

// Total users
$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$stats['users'] = $stmt->fetch()['total'];

// Total posts
$stmt = $pdo->query("SELECT COUNT(*) as total FROM posts WHERE status = 'published'");
$stats['posts'] = $stmt->fetch()['total'];

// Total reviews
$stmt = $pdo->query("SELECT COUNT(*) as total FROM product_reviews");
$stats['reviews'] = $stmt->fetch()['total'];

// Recent orders
$stmt = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
$recent_orders = $stmt->fetchAll();

// Orders by status
$stmt = $pdo->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
$orders_by_status = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

// Revenue by month (last 6 months)
$stmt = $pdo->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as revenue 
    FROM orders 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
    GROUP BY month
    ORDER BY month ASC
");
$revenue_by_month = $stmt->fetchAll();
?>

<!-- Admin Layout with Sidebar -->
<div class="admin-layout">
    <?php include 'views/layouts/admin_sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="admin-content">
        <div class="content-header">
            <h2><i class="bi bi-speedometer2"></i> Dashboard Overview</h2>
            <p>Welcome back, <?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?>!</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row row-cards mb-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Revenue</div>
                            <div class="ms-auto lh-1">
                                <div class="badge bg-success-lt">+12%</div>
                            </div>
                        </div>
                        <div class="h1 mb-3"><?= number_format($stats['revenue'], 0, ',', '.') ?>đ</div>
                        <div class="d-flex mb-2">
                            <div>Completed Orders</div>
                            <div class="ms-auto">
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    <i class="ti ti-trending-up"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total Orders</div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['orders'] ?></div>
                        <div class="d-flex mb-2">
                            <div>Pending: <?= $stats['pending_orders'] ?></div>
                            <div class="ms-auto">
                                <span class="text-warning d-inline-flex align-items-center lh-1">
                                    <i class="ti ti-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Products</div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['products'] ?></div>
                        <div class="d-flex mb-2">
                            <div>In Stock</div>
                            <div class="ms-auto">
                                <span class="text-blue d-inline-flex align-items-center lh-1">
                                    <i class="ti ti-package"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">New Messages</div>
                        </div>
                        <div class="h1 mb-3"><?= $stats['unread_contacts'] ?></div>
                        <div class="d-flex mb-2">
                            <div>Unread Contacts</div>
                            <div class="ms-auto">
                                <span class="text-primary d-inline-flex align-items-center lh-1">
                                    <i class="ti ti-mail"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row row-cards mb-3">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Revenue Overview (Last 6 Months)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Orders by Status</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Orders</h3>
                        <div class="card-actions">
                            <a href="?page=manage_orders" class="btn btn-primary btn-sm">
                                View All Orders
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td class="text-muted">#<?= $order['id'] ?></td>
                                    <td><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td><?= number_format($order['total'], 0, ',', '.') ?>đ</td>
                                    <td>
                                        <?php
                                        $statusClass = $order['status'] == 'completed' ? 'bg-success' : 
                                                      ($order['status'] == 'pending' ? 'bg-warning' : 'bg-secondary');
                                        ?>
                                        <span class="badge <?= $statusClass ?>"><?= $order['status'] ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="row row-cards mt-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-blue text-white avatar">
                                    <i class="ti ti-users"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium"><?= $stats['users'] ?> Users</div>
                                <div class="text-muted">Registered accounts</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-green text-white avatar">
                                    <i class="ti ti-file-text"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium"><?= $stats['posts'] ?> Posts</div>
                                <div class="text-muted">Published articles</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-yellow text-white avatar">
                                    <i class="ti ti-star"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium"><?= $stats['reviews'] ?> Reviews</div>
                                <div class="text-muted">Product reviews</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card card-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <span class="bg-purple text-white avatar">
                                    <i class="ti ti-shopping-cart"></i>
                                </span>
                            </div>
                            <div class="col">
                                <div class="font-weight-medium"><?= $stats['products'] ?> Products</div>
                                <div class="text-muted">In catalog</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
<script>
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($revenue_by_month, 'month')) ?>,
        datasets: [{
            label: 'Revenue (đ)',
            data: <?= json_encode(array_column($revenue_by_month, 'revenue')) ?>,
            borderColor: 'rgb(32, 107, 196)',
            backgroundColor: 'rgba(32, 107, 196, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('vi-VN') + 'đ';
                    }
                }
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_keys($orders_by_status)) ?>,
        datasets: [{
            data: <?= json_encode(array_values($orders_by_status)) ?>,
            backgroundColor: [
                'rgba(32, 107, 196, 0.8)',
                'rgba(251, 189, 8, 0.8)',
                'rgba(45, 206, 137, 0.8)',
                'rgba(214, 57, 57, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

</body>
</html>