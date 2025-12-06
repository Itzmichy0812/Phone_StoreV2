<?php
// File: views/admin/manage_orders.php
// KHÔNG cần session_start() vì index.php đã start rồi

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php?page=home");
    exit();
}

// Sử dụng $db từ index.php (đã connect rồi)
require_once __DIR__ . '/../../models/OrderModel.php';

$orderModel = new OrderModel($db);

// Handle POST update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['new_status'])) {
    $orderId = intval($_POST['order_id']);
    $newStatus = $_POST['new_status'];
    
    if ($orderModel->updateOrderStatus($orderId, $newStatus)) {
        $successMessage = "Order status updated successfully!";
    } else {
        $errorMessage = "Failed to update order status.";
    }
}

// Get filter
$status = isset($_GET['status']) ? $_GET['status'] : 'all';

// Get orders
$orders = $orderModel->getAllOrdersAdmin($status);

function getStatusColor($status) {
    switch($status) {
        case 'pending': return 'warning';
        case 'processing': return 'info';
        case 'shipped': return 'primary';
        case 'completed': return 'success';
        case 'cancelled': return 'danger';
        default: return 'secondary';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-dark text-white p-3" style="min-height: 100vh;">
                <h5 class="mb-4">Admin Panel</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=admin_dashboard">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white active bg-primary rounded" href="index.php?page=manage_orders">
                            <i class="bi bi-box-seam"></i> Manage Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=admin_reviews">
                            <i class="bi bi-star"></i> Manage Reviews
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="index.php?page=home">
                            <i class="bi bi-house"></i> Back to Site
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <h2 class="mb-4"><i class="bi bi-box-seam"></i> Manage Orders</h2>

                <?php if (isset($successMessage)): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?= $successMessage ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($errorMessage)): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?= $errorMessage ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Filter Tabs -->
                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link <?= $status === 'all' ? 'active' : '' ?>" 
                           href="index.php?page=manage_orders&status=all">
                            All Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $status === 'pending' ? 'active' : '' ?>" 
                           href="index.php?page=manage_orders&status=pending">
                            <span class="badge bg-warning text-dark">Pending</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $status === 'processing' ? 'active' : '' ?>" 
                           href="index.php?page=manage_orders&status=processing">
                            <span class="badge bg-info">Processing</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $status === 'completed' ? 'active' : '' ?>" 
                           href="index.php?page=manage_orders&status=completed">
                            <span class="badge bg-success">Completed</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $status === 'cancelled' ? 'active' : '' ?>" 
                           href="index.php?page=manage_orders&status=cancelled">
                            <span class="badge bg-danger">Cancelled</span>
                        </a>
                    </li>
                </ul>

                <!-- Orders Table -->
                <?php if (empty($orders)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No orders found for this filter.
                    </div>
                <?php else: ?>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer Info</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td>
                                            <a href="index.php?page=order_details&id=<?= $order['id'] ?>" 
                                            class="text-decoration-none fw-bold" 
                                            target="_blank"
                                            title="Xem chi tiết">
                                            <i class="bi bi-box-seam"></i> #<?= $order['id'] ?>
                                         </a>
                                        </td>

                                        <td>
                                            <strong><?= htmlspecialchars($order['customer_name']) ?></strong><br>
                                            <small class="text-muted">
                                                <i class="bi bi-envelope"></i> <?= htmlspecialchars($order['customer_email']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <small><?= date('d/m/Y', strtotime($order['created_at'])) ?></small><br>
                                            <small class="text-muted"><?= date('H:i', strtotime($order['created_at'])) ?></small>
                                        </td>
                                        <td><strong class="text-success"><?= number_format($order['total']) ?> ₫</strong></td>
                                        <td>
                                            <span class="badge bg-secondary">
                                                <?= ucfirst($order['payment_method']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?= getStatusColor($order['status']) ?>">
                                                <?= ucfirst($order['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <div class="input-group input-group-sm" style="max-width:200px;">
                                                    <select name="new_status" class="form-select form-select-sm">
                                                        <option value="">-- Change Status --</option>
                                                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Processing</option>
                                                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
