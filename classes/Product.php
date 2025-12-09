<?php
/**
 * Product Model Class
 * Handles product data operations
 */

require_once __DIR__ . '/Database.php';

class Product {
    private $db;
    private $id;
    private $title;
    private $price;
    private $description;
    private $category;
    private $image;
    private $ratingRate;
    private $ratingCount;

    /** Constructor*/
    public function __construct($data = []) {
        $this->db = new Database();
        
        if (!empty($data)) {
            $this->id = $data['id'] ?? null;
            $this->title = $data['title'] ?? '';
            $this->price = $data['price'] ?? 0;
            $this->description = $data['description'] ?? '';
            $this->category = $data['category'] ?? '';
            $this->image = $data['image'] ?? '';
            $this->ratingRate = $data['rating']['rate'] ?? $data['rating_rate'] ?? 0;
            $this->ratingCount = $data['rating']['count'] ?? $data['rating_count'] ?? 0;
        }
    }

    /** Save product to database (handles duplicates)*/
    public function save() {
        $conn = $this->db->getConnection();
        
        $sql = "INSERT INTO products (id, title, price, description, category, image, rating_rate, rating_count)
                VALUES (:id, :title, :price, :description, :category, :image, :rating_rate, :rating_count)
                ON DUPLICATE KEY UPDATE
                    title = VALUES(title),
                    price = VALUES(price),
                    description = VALUES(description),
                    category = VALUES(category),
                    image = VALUES(image),
                    rating_rate = VALUES(rating_rate),
                    rating_count = VALUES(rating_count),
                    updated_at = CURRENT_TIMESTAMP";

        $stmt = $conn->prepare($sql);
        
        return $stmt->execute([
            ':id' => $this->id,
            ':title' => $this->title,
            ':price' => $this->price,
            ':description' => $this->description,
            ':category' => $this->category,
            ':image' => $this->image,
            ':rating_rate' => $this->ratingRate,
            ':rating_count' => $this->ratingCount
        ]);
    }

    /**Get all products */
    public static function getAll($options = []) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM products WHERE 1=1";
        $params = [];

        // Filter by price above $100
        if (isset($options['min_price'])) {
            $sql .= " AND price >= :min_price";
            $params[':min_price'] = $options['min_price'];
        }

        // Sort by price
        if (isset($options['sort_by']) && $options['sort_by'] === 'price') {
            $order = isset($options['order']) && strtoupper($options['order']) === 'DESC' ? 'DESC' : 'ASC';
            $sql .= " ORDER BY price $order";
        } else {
            $sql .= " ORDER BY id ASC";
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    /** Get products by price range */
    public static function getByPriceRange($minPrice, $maxPrice = null) {
        $db = new Database();
        $conn = $db->getConnection();
        
        $sql = "SELECT * FROM products WHERE price >= :min_price";
        $params = [':min_price' => $minPrice];
        
        if ($maxPrice !== null) {
            $sql .= " AND price <= :max_price";
            $params[':max_price'] = $maxPrice;
        }
        
        $sql .= " ORDER BY price ASC";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    /**Get products sorted by price */
    public static function getSortedByPrice($order = 'ASC') {
        $db = new Database();
        $conn = $db->getConnection();
        
        $order = strtoupper($order) === 'DESC' ? 'DESC' : 'ASC';
        $sql = "SELECT * FROM products ORDER BY price $order";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getPrice() { return $this->price; }
    public function getDescription() { return $this->description; }
    public function getCategory() { return $this->category; }
    public function getImage() { return $this->image; }
    public function getRatingRate() { return $this->ratingRate; }
    public function getRatingCount() { return $this->ratingCount; }
}

