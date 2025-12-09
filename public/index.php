<?php

/**
 * Main Product Display Page
 * Displays products in a responsive grid layout with sorting and filtering
 */
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../classes/Product.php';

// Get URL parameters for sorting and filtering
$sortBy = $_GET['sort'] ?? '';
$filterAbove100 = isset($_GET['filter']) && $_GET['filter'] === 'above100';
$order = $_GET['order'] ?? 'ASC';

// Prepare options for Product::getAll()
$options = [];

if ($filterAbove100) {
    $options['min_price'] = 100;
}

if ($sortBy === 'price') {
    $options['sort_by'] = 'price';
    $options['order'] = $order;
}

// Fetch products
try {
    $products = Product::getAll($options);
} catch (Exception $e) {
    $products = [];
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Store</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/css/uikit.min.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- Navigation -->
    <nav class="uk-navbar-container">
        <div class="uk-container">
            <div uk-navbar>
                <div class="uk-navbar-left">
                    <a class="uk-navbar-item uk-logo" href="#" aria-label="Back to Home">Product Store</a>
                    <div class="uk-navbar-item">
                        <a class="uk-button uk-button-default" target="_blank" href="/scripts/import.php">Import
                            Products</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Header -->
    <div class="uk-container uk-container-large uk-margin-top">
        <header class="uk-margin-bottom">
            <h1 class="uk-heading-medium uk-text-center">All Products</h1>
        </header>
        <div uk-grid>
            <div class="uk-width-1-1 uk-width-1-4@s">
                <?php include __DIR__ .'/parts/filter-panel.php'; ?>   
            </div>
            <div class="uk-width-1-1 uk-width-3-4@s">
                <!-- Error Message -->
                <?php if (isset($error)): ?>
                <div class="uk-alert-danger" uk-alert>
                    <a class="uk-alert-close" uk-close></a>
                    <p>Error loading products: <?php echo sanitize($error); ?></p>
                </div>
                <?php endif; ?>

                <!-- Products card -->
                <?php if (empty($products)): ?>
                <div class="uk-alert-warning" uk-alert>
                    <p>No products found. <a href="../scripts/import.php">Import products from API</a></p>
                </div>
                <?php else: ?>
               <?php include __DIR__.'/parts/product-card.php'; ?>
            </div>

            <!-- Product Count -->
            <div class="uk-text-center uk-margin-top">
                <p class="uk-text-muted">Displaying <?php echo count($products); ?> product(s)</p>
            </div>
            <?php endif; ?>

        </div>

    </div>
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.17.11/dist/js/uikit-icons.min.js"></script>
    <script src="uikit/dist/js/uikit-icons.min.js"></script>
</body>

</html>