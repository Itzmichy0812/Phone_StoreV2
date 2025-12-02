<?php
// models/ProductModel.php

class ProductModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // CẬP NHẬT: Thêm tham số $sort = 'default'
    public function getAllProducts($limit = 12, $offset = 0, $sort = 'default') {
        try {
            // 1. Khởi tạo câu truy vấn cơ bản
            $query = "SELECT * FROM products";
            
            // 2. Xử lý logic sắp xếp (Nối thêm ORDER BY vào chuỗi $query)
            // Lưu ý: Không dùng bindParam cho ORDER BY được, phải nối chuỗi an toàn như này
            switch ($sort) {
                case 'price_asc':
                    $query .= " ORDER BY price ASC"; // Giá thấp -> cao
                    break;
                case 'price_desc':
                    $query .= " ORDER BY price DESC"; // Giá cao -> thấp
                    break;
                case 'name_asc':
                    $query .= " ORDER BY name ASC";   // Tên A -> Z
                    break;
                default:
                    $query .= " ORDER BY created_at DESC"; // Mặc định: Mới nhất lên đầu
                    break;
            }

            // 3. Nối thêm phần phân trang
            $query .= " LIMIT :limit OFFSET :offset";
            
            // 4. Chuẩn bị và thực thi
            $stmt = $this->conn->prepare($query);
            
            // Bind số nguyên cho limit và offset
            $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return [];
        }
    }

    // Đếm tổng số sản phẩm (Giữ nguyên)
    public function countProducts() {
        $query = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['total'];
    }
    
    // Lấy chi tiết 1 sản phẩm (Giữ nguyên)
    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    //METHOD FILTER
    public function getFilteredProducts($filters = [], $limit = 12, $offset = 0, $sort = 'default') {
    $query = "SELECT * FROM products WHERE 1=1";
    $params = [];
    
    // Brand filter
    if (!empty($filters['brand'])) {
        $brands = $filters['brand']; // Array
        $placeholders = implode(',', array_fill(0, count($brands), '?'));
        $query .= " AND brand IN ($placeholders)";
        $params = array_merge($params, $brands);
    }
    
    // Price filter
    if (!empty($filters['price_min'])) {
        $query .= " AND price >= ?";
        $params[] = $filters['price_min'];
    }
    if (!empty($filters['price_max'])) {
        $query .= " AND price <= ?";
        $params[] = $filters['price_max'];
    }
    
    // Storage filter
    if (!empty($filters['storage'])) {
        $storages = $filters['storage'];
        $placeholders = implode(',', array_fill(0, count($storages), '?'));
        $query .= " AND storage IN ($placeholders)";
        $params = array_merge($params, $storages);
    }
    
    // Category filter
    if (!empty($filters['category'])) {
        $query .= " AND category = ?";
        $params[] = $filters['category'];
    }
    
    // Sorting
    switch ($sort) {
        case 'price_asc': $query .= " ORDER BY price ASC"; break;
        case 'price_desc': $query .= " ORDER BY price DESC"; break;
        case 'name_asc': $query .= " ORDER BY name ASC"; break;
        default: $query .= " ORDER BY created_at DESC";
    }
    
    $query .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;
    
    $stmt = $this->conn->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
    }

    // Method lấy unique values cho filter dropdowns
    public function getFilterOptions() {
        return [
            'brands' => $this->conn->query("SELECT DISTINCT brand FROM products WHERE brand IS NOT NULL ORDER BY brand")->fetchAll(PDO::FETCH_COLUMN),
            'storages' => $this->conn->query("SELECT DISTINCT storage FROM products WHERE storage IS NOT NULL ORDER BY storage")->fetchAll(PDO::FETCH_COLUMN),
            'categories' => $this->conn->query("SELECT DISTINCT category FROM products ORDER BY category")->fetchAll(PDO::FETCH_COLUMN)
        ];
    }

    public function countFilteredProducts($filters = []) {
        try {
            // Build query giống hệt getFilteredProducts() nhưng chỉ COUNT
            $query = "SELECT COUNT(*) as total FROM products WHERE 1=1";
            $params = [];
            
            // 1. Brand filter
            if (!empty($filters['brand']) && is_array($filters['brand'])) {
                $placeholders = implode(',', array_fill(0, count($filters['brand']), '?'));
                $query .= " AND brand IN ($placeholders)";
                $params = array_merge($params, $filters['brand']);
            }
            
            // 2. Category filter
            if (!empty($filters['category'])) {
                $query .= " AND category = ?";
                $params[] = $filters['category'];
            }
            
            // 3. Storage filter
            if (!empty($filters['storage']) && is_array($filters['storage'])) {
                $placeholders = implode(',', array_fill(0, count($filters['storage']), '?'));
                $query .= " AND storage IN ($placeholders)";
                $params = array_merge($params, $filters['storage']);
            }
            
            // 4. Price range filter
            if (!empty($filters['price_min']) && is_numeric($filters['price_min'])) {
                $query .= " AND price >= ?";
                $params[] = (float)$filters['price_min'];
            }
            
            if (!empty($filters['price_max']) && is_numeric($filters['price_max'])) {
                $query .= " AND price <= ?";
                $params[] = (float)$filters['price_max'];
            }
            
            // Execute query
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return (int)$row['total'];
            
        } catch (PDOException $e) {
            echo "Error counting products: " . $e->getMessage();
            return 0;
        }
    }

    public function getProductImages($productId) {
        try {
            $query = "SELECT * FROM product_images 
                      WHERE product_id = ? 
                      ORDER BY is_primary DESC, display_order ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching product images: " . $e->getMessage());
            return [];
        }
    }

    public function getProductVariants($productId, $type = null) {
        try {
            if ($type) {
                $query = "SELECT * FROM product_variants 
                          WHERE product_id = ? AND variant_type = ? 
                          ORDER BY is_default DESC, price_modifier ASC";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$productId, $type]);
            } else {
                $query = "SELECT * FROM product_variants 
                          WHERE product_id = ? 
                          ORDER BY variant_type, is_default DESC";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$productId]);
            }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching variants: " . $e->getMessage());
            return [];
        }
    }

    public function getProductVariantsGrouped($productId) {
        try {
            $query = "SELECT * FROM product_variants 
                      WHERE product_id = ? 
                      ORDER BY variant_type, is_default DESC, price_modifier ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            $variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Group by type
            $grouped = [
                'storage' => [],
                'color' => [],
                'ram' => []
            ];
            
            foreach ($variants as $variant) {
                $grouped[$variant['variant_type']][] = $variant;
            }
            
            return $grouped;
        } catch (PDOException $e) {
            error_log("Error fetching grouped variants: " . $e->getMessage());
            return ['storage' => [], 'color' => [], 'ram' => []];
        }
    }

    public function getDefaultVariants($productId) {
        try {
            $query = "SELECT * FROM product_variants 
                      WHERE product_id = ? AND is_default = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function calculatePrice($productId, $selectedVariants = []) {
        try {
            // Get base price
            $product = $this->getProductById($productId);
            $basePrice = (float)$product['price'];
            
            // Add price modifiers
            foreach ($selectedVariants as $variantId) {
                $query = "SELECT price_modifier FROM product_variants WHERE id = ?";
                $stmt = $this->conn->prepare($query);
                $stmt->execute([$variantId]);
                $variant = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($variant) {
                    $basePrice += (float)$variant['price_modifier'];
                }
            }
            
            return $basePrice;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getProductReviews($productId, $limit = 10) {
        // Tạm thời return empty
        // Sau khi có user login, query từ product_reviews table
        return [];
    }

    public function getRelatedProducts($currentProductId, $category, $limit = 4) {
        try {
            $query = "SELECT p.*, 
                             (SELECT image_url FROM product_images 
                              WHERE product_id = p.id AND is_primary = 1 
                              LIMIT 1) as primary_image
                      FROM products p
                      WHERE p.category = ? 
                      AND p.id != ? 
                      ORDER BY RAND() 
                      LIMIT ?";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$category, $currentProductId, $limit]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching related products: " . $e->getMessage());
            return [];
        }
    }

}


    
?>