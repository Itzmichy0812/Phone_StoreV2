<?php
/**
 * OrderModel.php
 * Xử lý orders và order_items
 */

class OrderModel {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    /**
     * Tạo đơn hàng mới
     * @param array $orderData
     * @return int|false Order ID hoặc false nếu lỗi
     */
    public function createOrder($orderData) {
        try {
            $this->db->beginTransaction();

            // Insert vào bảng orders
            $sql = "INSERT INTO orders (
                customer_name,
                customer_email,
                customer_phone,
                shipping_address,
                shipping_city,
                shipping_district,
                shipping_ward,
                payment_method,
                subtotal,
                shipping_fee,
                tax,
                total,
                status,
                notes,
                created_at
            ) VALUES (
                :customer_name,
                :customer_email,
                :customer_phone,
                :shipping_address,
                :shipping_city,
                :shipping_district,
                :shipping_ward,
                :payment_method,
                :subtotal,
                :shipping_fee,
                :tax,
                :total,
                'pending',
                :notes,
                NOW()
            )";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':customer_name' => $orderData['customer_name'],
                ':customer_email' => $orderData['customer_email'],
                ':customer_phone' => $orderData['customer_phone'],
                ':shipping_address' => $orderData['shipping_address'],
                ':shipping_city' => $orderData['shipping_city'],
                ':shipping_district' => $orderData['shipping_district'] ?? '',
                ':shipping_ward' => $orderData['shipping_ward'] ?? '',
                ':payment_method' => $orderData['payment_method'],
                ':subtotal' => $orderData['subtotal'],
                ':shipping_fee' => $orderData['shipping_fee'],
                ':tax' => $orderData['tax'],
                ':total' => $orderData['total'],
                ':notes' => $orderData['notes'] ?? ''
            ]);

            $orderId = $this->db->lastInsertId();

            // Insert order items
            if (isset($orderData['items']) && !empty($orderData['items'])) {
                $this->addOrderItems($orderId, $orderData['items']);
            }

            $this->db->commit();
            return $orderId;

        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("OrderModel createOrder error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Thêm items vào order
     */
    private function addOrderItems($orderId, $items) {
        $sql = "INSERT INTO order_items (
            order_id,
            product_id,
            product_name,
            product_price,
            quantity,
            subtotal
        ) VALUES (
            :order_id,
            :product_id,
            :product_name,
            :product_price,
            :quantity,
            :subtotal
        )";

        $stmt = $this->db->prepare($sql);

        foreach ($items as $item) {
            $stmt->execute([
                ':order_id' => $orderId,
                ':product_id' => $item['product_id'],
                ':product_name' => $item['product_name'],
                ':product_price' => $item['product_price'],
                ':quantity' => $item['quantity'],
                ':subtotal' => $item['subtotal']
            ]);

            // Giảm stock của sản phẩm
            $this->decreaseProductStock($item['product_id'], $item['quantity']);
        }
    }

    /**
     * Giảm số lượng stock
     */
    private function decreaseProductStock($productId, $quantity) {
        $sql = "UPDATE products SET stock = stock - :quantity WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':quantity' => $quantity,
            ':id' => $productId
        ]);
    }

    /**
     * Lấy thông tin order theo ID
     */
    public function getOrderById($orderId) {
        $sql = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lấy order items
     */
    public function getOrderItems($orderId) {
        $sql = "SELECT * FROM order_items WHERE order_id = :order_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Cập nhật trạng thái order
     */
    public function updateOrderStatus($orderId, $status) {
        $sql = "UPDATE orders SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $orderId
        ]);
    }
}
?>
