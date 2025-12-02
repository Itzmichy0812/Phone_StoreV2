<?php
/**
 * AJAX Handler cho Shopping Cart
 * Xử lý: add, update, remove, get cart
 */

// Start session
session_start();

// Include dependencies
require_once '../config/db.php';
require_once '../models/CartModel.php';

// Set JSON header
header('Content-Type: application/json');

error_log("Cart Handler Called - Action: " . ($_POST['action'] ?? 'none'));

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Get action from POST
$action = $_POST['action'] ?? '';

// Initialize database
$database = new Database();
$db = $database->connect();

// Process action
switch ($action) {
    
    case 'add':
        $productId = $_POST['product_id'] ?? 0;
        $quantity = intval($_POST['quantity'] ?? 1);  // ✅ Lấy quantity từ request

        error_log("ADD TO CART - Product ID: $productId, Quantity: $quantity");
        
        if ($productId > 0 && $quantity > 0) {
            require_once '../models/ProductModel.php';
            $productModel = new ProductModel($db);
            $product = $productModel->getProductById($productId);
        
            if (!$product) {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
            exit;
            }


            // ✅ THAY ĐỔI: Thay vì cộng thêm, ta SET quantity mới
            if (isset($_SESSION['cart'][$productId])) {
                // Nếu đã có trong cart, CỘNG THÊM quantity
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
                error_log("Product exists, new total: " . $_SESSION['cart'][$productId]['quantity']);
            } else {
                // Nếu chưa có, tạo mới với quantity từ request
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => floatval($product['price']),
                    'image' => $product['image'],
                    'category' => $product['category'] ?? 'Uncategorized',
                    'brand' => $product['brand'] ?? '',
                    'stock' => intval($product['stock']),
                    'quantity' => $quantity
                ];
                error_log("New product added with quantity: $quantity");
            }

            $itemCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
            error_log("Total items in cart: $itemCount");
            
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart',
                'itemCount' => $itemCount
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid product or quantity']);
        }
        break;
    
    case 'update':
        $productId = $_POST['product_id'] ?? 0;
        $quantity = intval($_POST['quantity'] ?? 1);
        
        if (isset($_SESSION['cart'][$productId])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $quantity;
                echo json_encode(['success' => true]);
            } else {
                unset($_SESSION['cart'][$productId]);
                echo json_encode(['success' => true, 'message' => 'Item removed']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not in cart']);
        }
        break;
    
    case 'remove':
        $productId = $_POST['product_id'] ?? 0;
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        
        echo json_encode(['success' => true]);
        }
        else {
            echo json_encode(['success' => false, 'message' => 'Product not in cart']);
        }
        break;
    
    case 'get':
        // Get full cart with product details
        require_once '../config/db.php';
        require_once '../models/ProductModel.php';
        
        $database = new Database();
        $db = $database->connect();
        $productModel = new ProductModel($db);
        
        $cartItems = [];
        $total = 0;
        
        foreach ($_SESSION['cart'] as $productId => $item) {
            $product = $productModel->getProductById($productId);
            if ($product) {
                $cartItems[$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'image' => $product['image'],
                    'category' => $product['category'],
                    'quantity' => $item['quantity']
                ];
                $total += $product['price'] * $item['quantity'];
            }
        }
        
        echo json_encode([
            'success' => true,
            'cart' => $cartItems,
            'itemCount' => array_sum(array_column($_SESSION['cart'], 'quantity')),
            'total' => $total
        ]);
        break;
    
    case 'clear':
        // Xóa toàn bộ giỏ hàng
        CartModel::clearCart();
        
        echo json_encode([
            'success' => true,
            'message' => 'Cart cleared!'
        ]);
        break;
    
    default:
        echo json_encode([
            'success' => false,
            'message' => 'Invalid action!'
        ]);
        break;
}
?>
