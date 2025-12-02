<?php
// File: controllers/ProductController.php

require_once 'config/db.php';
require_once 'models/ProductModel.php';

class ProductController {
    
    public function show() {
        // 1. Get product ID
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        if ($productId <= 0) {
            header('Location: ?page=shop');
            exit();
        }
        
        // 2. Initialize database and model
        $database = new Database();
        $db = $database->connect();
        $productModel = new ProductModel($db);
        
        // 3. Get product details
        $product = $productModel->getProductById($productId);
        
        if (!$product) {
            header('Location: ?page=shop');
            exit();
        }
        
        // 4. Get product images
        $productImages = $productModel->getProductImages($productId);
        
        // Nếu không có ảnh trong product_images, fallback về ảnh chính
        if (empty($productImages)) {
            $productImages = [[
                'image_url' => $product['image'],
                'is_primary' => 1,
                'display_order' => 0
            ]];
        }
        
        // 5. Get product variants (grouped by type)
        $variants = $productModel->getProductVariantsGrouped($productId);
        
        // 6. Get default variants
        $defaultVariants = $productModel->getDefaultVariants($productId);
        
        // 7. Get related products
        $relatedProducts = $productModel->getRelatedProducts($productId, $product['category'], 4);
        
        // 8. Reviews (placeholder - empty for now)
        $reviews = $productModel->getProductReviews($productId);
        
        // 9. Calculate default price (with default variants)
        $displayPrice = $product['price'];
        foreach ($defaultVariants as $defaultVar) {
            $displayPrice += $defaultVar['price_modifier'];
        }
        
        // 10. Load view
        include 'views/client/product_detail.php';
    }
}
?>
