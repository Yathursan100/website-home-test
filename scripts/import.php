<?php
/**
 * Import Script
 * Fetches products from FakeStore API and stores them in the database
 */

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../classes/ApiFetcher.php';
require_once __DIR__ . '/../classes/Product.php';

// Set content type for web access
if (php_sapi_name() !== 'cli') {
    header('Content-Type: text/html; charset=utf-8');
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Products</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
        .info { color: #004085; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>Product Import Script</h1>
    <?php

try {
    echo "<div class='info'>Starting import process...</div>";

    // Initialize API Fetcher
    $apiFetcher = new ApiFetcher();
    $products = $apiFetcher->fetchProducts();
    
    if (empty($products)) {
        throw new Exception("No products received from API");
    }
    
    echo "<div class='info'>Received " . count($products) . " products from API</div>";
    //Preparing data for storage
    $preparedProducts = $apiFetcher->prepareForStorage($products);
    
    echo "<div class='info'>" . count($preparedProducts) . " are storage</div>";
    
    
} catch (Exception $e) {
    echo "<div class='error'>";
    echo "<h2>Import Failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p>Please check your database configuration and ensure the database and table exist.</p>";
    echo "</div>";
}

?>
</body>
</html>

