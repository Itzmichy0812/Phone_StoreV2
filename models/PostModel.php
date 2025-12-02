<?php
// models/PostModel.php

class PostModel {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Get all active categories with post count
     * @return array
     */
    public function getCategories() {
        $query = "SELECT pc.*, COUNT(p.id) as post_count 
            FROM post_categories pc 
            LEFT JOIN posts p ON pc.id = p.category_id AND p.status = 'published'
            WHERE pc.status = 'active' 
            GROUP BY pc.id 
            ORDER BY pc.display_order ASC";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting categories: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Get post by ID
     * @param int $postId
     * @return array|null
     */
    public function getPostById($postId) {
        $query = "SELECT 
            p.id,
            p.title,
            p.content,
            p.image,
            p.view_count,
            p.created_at,
            p.category_id,
            a.full_name as author_name,
            pc.name as category_name,
            pc.color as category_color
        FROM posts p
        LEFT JOIN admins a ON p.admin_id = a.id
        LEFT JOIN post_categories pc ON p.category_id = pc.id
        WHERE p.id = ? AND p.status = 'published'";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$postId]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error getting post: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get posts with pagination and filters
     * @param int $page
     * @param int $limit
     * @param int|null $categoryId
     * @param string $search
     * @return array
     */
    public function getPosts($page = 1, $limit = 3, $categoryId = null, $search = '') {
        $offset = ($page - 1) * $limit;
        
        $sql = "SELECT 
            p.id,
            p.title,
            p.content,
            p.image,
            p.view_count,
            p.created_at,
            a.full_name as author_name,
            pc.name as category_name,
            pc.color as category_color
        FROM posts p
        LEFT JOIN admins a ON p.admin_id = a.id
        LEFT JOIN post_categories pc ON p.category_id = pc.id
        WHERE p.status = 'published'";
        
        $params = [];
        
        // Add category filter
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        
        // Add search filter
        if ($search) {
            $sql .= " AND (p.title LIKE ? OR p.content LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        // Order by newest first
        $sql .= " ORDER BY p.created_at DESC";
        
        // Add limit and offset
        $sql .= " LIMIT {$limit} OFFSET {$offset}";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("SQL Error: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Count total posts with filters
     * @param int|null $categoryId
     * @param string $search
     * @return int
     */
    public function countPosts($categoryId = null, $search = '') {
        $sql = "SELECT COUNT(*) as total FROM posts p WHERE p.status = 'published'";
        $params = [];
        
        if ($categoryId) {
            $sql .= " AND p.category_id = ?";
            $params[] = $categoryId;
        }
        
        if ($search) {
            $sql .= " AND (p.title LIKE ? OR p.content LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error counting posts: " . $e->getMessage());
            return 0;
        }
    }
    
    /**
     * Get related posts by category
     * @param int $categoryId
     * @param int $excludePostId
     * @param int $limit
     * @return array
     */
    public function getRelatedPosts($categoryId, $excludePostId, $limit = 5) {
        if (!$categoryId) {
            return [];
        }
        
        $query = "SELECT 
            p.id,
            p.title,
            p.image,
            p.view_count,
            p.created_at
        FROM posts p
        WHERE p.category_id = ? AND p.id != ? AND p.status = 'published'
        ORDER BY p.created_at DESC
        LIMIT ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$categoryId, $excludePostId, $limit]);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error getting related posts: " . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Increment post view count
     * @param int $postId
     * @return bool
     */
    public function incrementViewCount($postId) {
        $query = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$postId]);
        } catch (PDOException $e) {
            error_log("Error incrementing view count: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Create a new post
     * @param array $data
     * @return int|false Post ID or false on failure
     */
    public function createPost($data) {
        $query = "INSERT INTO posts (admin_id, category_id, title, content, image, status) 
                  VALUES (?, ?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                $data['admin_id'],
                $data['category_id'] ?? null,
                $data['title'],
                $data['content'],
                $data['image'] ?? null,
                $data['status'] ?? 'draft'
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error creating post: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Update post
     * @param int $postId
     * @param array $data
     * @return bool
     */
    public function updatePost($postId, $data) {
        $query = "UPDATE posts SET 
                  category_id = ?, 
                  title = ?, 
                  content = ?, 
                  image = ?, 
                  status = ?
                  WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([
                $data['category_id'] ?? null,
                $data['title'],
                $data['content'],
                $data['image'] ?? null,
                $data['status'] ?? 'draft',
                $postId
            ]);
        } catch (PDOException $e) {
            error_log("Error updating post: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Delete post
     * @param int $postId
     * @return bool
     */
    public function deletePost($postId) {
        $query = "DELETE FROM posts WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$postId]);
        } catch (PDOException $e) {
            error_log("Error deleting post: " . $e->getMessage());
            return false;
        }
    }
}
?>
