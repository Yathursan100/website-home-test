<?php
/**
 * Helper Functions
 */

/**Autoload classes*/
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/../classes/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

/** Sanitize output*/
function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/** Format price */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/** Truncate text */
function truncateText($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}

