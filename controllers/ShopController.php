<?php
// controllers/ShopController.php

require_once 'config/db.php';
require_once 'models/ProductModel.php';

class ShopController {
    public function index() {
        // 1. Khởi tạo kết nối
        $database = new Database();
        $db = $database->connect();
        $productModel = new ProductModel($db);

        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';

        // 2. Xử lý Phân trang (Pagination Logic)
        $limit = 8; // Số sản phẩm mỗi trang (Bạn có thể chỉnh thành 12, 16)
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1; // Lấy trang hiện tại từ URL (ví dụ ?page=shop&p=2)
        if ($page < 1) $page = 1;
        
        $offset = ($page - 1) * $limit; // Tính vị trí bắt đầu lấy

        

        //FOR FILTERING
        $filters = [
        'brand' => isset($_GET['brand']) && is_array($_GET['brand']) ? $_GET['brand'] : [],
        'category' => isset($_GET['category']) ? $_GET['category'] : null,
        'storage' => isset($_GET['storage']) && is_array($_GET['storage']) ? $_GET['storage'] : [],
        'price_min' => isset($_GET['price_min']) && is_numeric($_GET['price_min']) ? (float)$_GET['price_min'] : null,
        'price_max' => isset($_GET['price_max']) && is_numeric($_GET['price_max']) ? (float)$_GET['price_max'] : null,
        ];

        $products = $productModel->getFilteredProducts($filters, $limit, $offset, $sort);
        $totalProducts = $productModel->countFilteredProducts($filters);
        $totalPages = ceil($totalProducts / $limit);
        $filterOptions = $productModel->getFilterOptions();


        // 4. Gửi dữ liệu sang View
        // Biến $products và $totalPages sẽ được dùng bên file view
        include 'views/client/shop.php';
    }


}
?>