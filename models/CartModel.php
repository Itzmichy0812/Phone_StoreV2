<?php
/**
 * CartModel.php
 * Model xử lý giỏ hàng (Session-based cart)
 */

class CartModel {
    private static $db;

    /**
     * Khởi tạo session và database connection
     */
    public static function init($dbConnection = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if ($dbConnection) {
            self::$db = $dbConnection;
        }
    }

    /**
     * Set database connection
     */
    public static function setDatabase($dbConnection) {
        self::$db = $dbConnection;
    }

    /**
     * ✅ Thêm sản phẩm vào giỏ hàng
     * @param int $productId
     * @param int $quantity
     * @return bool
     */
    public static function addItem($productId, $quantity = 1) {
        self::init();

        // Validate
        $productId = intval($productId);
        $quantity = intval($quantity);

        if ($productId <= 0 || $quantity <= 0) {
            return false;
        }

        // ✅ Lấy thông tin sản phẩm từ database (bao gồm brand và stock)
        if (self::$db) {
            try {
                $stmt = self::$db->prepare("
                    SELECT id, name, price, image, category, brand, stock 
                    FROM products 
                    WHERE id = ?
                ");
                $stmt->execute([$productId]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$product) {
                    error_log("CartModel: Product ID $productId not found");
                    return false;
                }

                // ✅ Kiểm tra stock
                if ($product['stock'] < $quantity) {
                    error_log("CartModel: Insufficient stock for Product ID $productId");
                    return false;
                }

                // ✅ Nếu sản phẩm đã có trong cart, tăng quantity
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    // ✅ Thêm sản phẩm mới vào cart với đầy đủ thông tin
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
                }

                return true;

            } catch (PDOException $e) {
                error_log("CartModel addItem error: " . $e->getMessage());
                return false;
            }
        }

        // ✅ Fallback: Nếu không có DB connection, chỉ lưu ID và quantity
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
        }

        return true;
    }

    /**
     * ✅ Cập nhật số lượng sản phẩm
     * @param int $productId
     * @param int $quantity Số lượng mới
     * @return bool
     */
    public static function updateQuantity($productId, $quantity) {
        self::init();

        $productId = intval($productId);
        $quantity = intval($quantity);

        if ($quantity <= 0) {
            // Nếu quantity <= 0, xóa sản phẩm
            return self::removeItem($productId);
        }

        if (isset($_SESSION['cart'][$productId])) {
            // ✅ Kiểm tra stock nếu có
            if (isset($_SESSION['cart'][$productId]['stock'])) {
                $maxStock = $_SESSION['cart'][$productId]['stock'];
                if ($quantity > $maxStock) {
                    error_log("CartModel: Cannot update - quantity exceeds stock");
                    return false;
                }
            }

            $_SESSION['cart'][$productId]['quantity'] = $quantity;
            return true;
        }

        return false;
    }

    /**
     * ✅ Xóa sản phẩm khỏi giỏ hàng
     * @param int $productId
     * @return bool
     */
    public static function removeItem($productId) {
        self::init();
        
        $productId = intval($productId);

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            return true;
        }

        return false;
    }

    /**
     * ✅ Lấy toàn bộ giỏ hàng
     * @return array
     */
    public static function getCart() {
        self::init();
        return $_SESSION['cart'];
    }

    /**
     * ✅ Lấy cart với product details từ database
     * @return array
     */
    public static function getCartWithDetails() {
    self::init();

    $cartItems = [];

    if (!self::$db) {
        error_log("CartModel::getCartWithDetails - Database not set");
        return $_SESSION['cart']; // Return raw cart nếu không có DB
    }

    if (empty($_SESSION['cart'])) {
        return [];
    }

    foreach ($_SESSION['cart'] as $productId => $item) {
        // ✅ Nếu item đã có đầy đủ thông tin (name, price, image), dùng luôn
        if (isset($item['name']) && isset($item['price']) && isset($item['image'])) {
            $cartItems[$productId] = $item;
            continue;
        }

        // ✅ Nếu chỉ có product_id, query từ database
        try {
            $stmt = self::$db->prepare("
                SELECT id, name, price, image, category, brand, stock 
                FROM products 
                WHERE id = ?
            ");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $cartItems[$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => floatval($product['price']),
                    'image' => $product['image'],
                    'category' => $product['category'] ?? 'Uncategorized',
                    'brand' => $product['brand'] ?? '',
                    'stock' => intval($product['stock']),
                    'quantity' => intval($item['quantity'])
                ];

                error_log("CartModel::getCartWithDetails - Loaded product: " . $product['name']);
            } else {
                error_log("CartModel::getCartWithDetails - Product not found: $productId");
            }
        } catch (PDOException $e) {
            error_log("CartModel::getCartWithDetails error: " . $e->getMessage());
        }
    }

        return $cartItems;
    }

    /**
     * ✅ Tính tổng tiền giỏ hàng
     * @return float
     */
    public static function getTotal() {
        self::init();

        $total = 0.0;

        foreach ($_SESSION['cart'] as $item) {
            // ✅ Kiểm tra key tồn tại trước khi tính
            if (isset($item['price']) && isset($item['quantity'])) {
                $total += floatval($item['price']) * intval($item['quantity']);
            }
        }

        return $total;
    }

    /**
     * ✅ Đếm tổng số lượng sản phẩm trong giỏ
     * @return int
     */
    public static function getItemCount() {
        self::init();

        $count = 0;

        foreach ($_SESSION['cart'] as $item) {
            if (isset($item['quantity'])) {
                $count += intval($item['quantity']);
            }
        }

        return $count;
    }

    /**
     * ✅ Xóa toàn bộ giỏ hàng
     * @return bool
     */
    public static function clearCart() {
        self::init();
        $_SESSION['cart'] = [];
        return true;
    }

    /**
     * ✅ Kiểm tra giỏ hàng có trống không
     * @return bool
     */
    public static function isEmpty() {
        self::init();
        return empty($_SESSION['cart']);
    }

    /**
     * ✅ Kiểm tra sản phẩm có trong giỏ hàng không
     * @param int $productId
     * @return bool
     */
    public static function hasItem($productId) {
        self::init();
        return isset($_SESSION['cart'][$productId]);
    }

    /**
     * ✅ Lấy quantity của 1 sản phẩm trong cart
     * @param int $productId
     * @return int
     */
    public static function getItemQuantity($productId) {
        self::init();

        if (isset($_SESSION['cart'][$productId]['quantity'])) {
            return intval($_SESSION['cart'][$productId]['quantity']);
        }

        return 0;
    }
}
?>
