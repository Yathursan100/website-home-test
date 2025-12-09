<?php
/**
 * Database Connection PDO
 */

class Database {
    private $connection = null;
    private $config = null;

    /** Constructor - loads database configuration */
    public function __construct() {
        $this->config = require __DIR__ . '/../config/database.php';
    }

    /** Establish database connection */
    public function connect() {
        if ($this->connection === null) {
            try {
                $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset={$this->config['charset']}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                $this->connection = new PDO(
                    $dsn,
                    $this->config['username'],
                    $this->config['password'],
                    $options
                );
            } catch (PDOException $e) {
                error_log("Database Connection Error: " . $e->getMessage());
                throw new Exception("Failed to connect to database. Please check your configuration.");
            }
        }

        return $this->connection;
    }
    /** Get the database connection */
    public function getConnection() {
        return $this->connect();
    }

    /** Close database connection */
    public function close() {
        $this->connection = null;
    }
}

