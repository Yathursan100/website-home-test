## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server (or XAMPP/WAMP)
- cURL extension enabled in PHP

## Installation

### 1. Clone the Repository

```bash
git clone <your-repository-url>
cd fileName
```

### 2. Database Setup

1. Create a MySQL database:
   ```sql
   CREATE DATABASE db_name;
   ```

2. Import the database schema:
   ```bash
   CREATE DATABASE IF NOT EXISTS product_app;
USE product_app;

CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    image VARCHAR(500),
    rating_rate DECIMAL(3,2) DEFAULT 0.00,
    rating_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_price (price)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
   ```

3. Configure database connection:
   ```php
   return [
       'host' => 'localhost',
       'dbname' => 'product_app',
       'username' => 'root',
       'password' => 'your_password',
       'charset' => 'utf8mb4'
   ];
   ```

### 3. Web Server Configuration

#### Using XAMPP (Windows)
1. Place the project in `C:\xampp\htdocs\`
2. Access via: `http://localhost/<fileName>/public/index.php`

### 4. Import Products

1. **Via Web Browser:**
   - Navigate to: `http://localhost/php_developer/scripts/import.php`
   - The script will fetch products from the API and store them in the database

2. **Via Command Line:**
   ```bash
   php scripts/import.php
   ```

### 5. View Products

Navigate to: `http://localhost/php_developer/public/index.php`



## Object-Oriented Design

### Database Class
- Encapsulates MySQL connection using PDO
- Handles connection errors gracefully
- Singleton pattern for connection reuse

### Product Class
- Represents product entity
- Methods: `save()`, `getAll()`, `getByPriceRange()`, `getSortedByPrice()`
- Handles duplicate prevention

### ApiFetcher Class
- Fetches data from external API
- Decodes JSON responses
- Prepares data for database storage
- Error handling for API failures

## Technologies Used

- **PHP**: Server-side scripting
- **MySQL**: Database management
- **PDO**: Database abstraction layer
- **UIkit 3**: CSS framework
- **cURL**: API requests
- **Git**: Version control



