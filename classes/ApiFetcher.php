<?php
/**
 * API Data processing
 */

class ApiFetcher {
    private $apiUrl = 'https://fakestoreapi.com/products';
    private $timeout = 30;

    /** Fetch products from API */
    public function fetchProducts() {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Content-Type: application/json'
            ]
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);

        if ($error) {
            error_log("API Fetch Error: " . $error);
            throw new Exception("Failed to fetch data from API: " . $error);
        }

        if ($httpCode !== 200) {
            error_log("API HTTP Error: Status code " . $httpCode);
            throw new Exception("API returned status code: " . $httpCode);
        }

        return $this->decodeJson($response);
    }

    /** Decode JSON response*/
    public function decodeJson($json) {
        if (empty($json)) {
            throw new Exception("Empty response from API");
        }

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("JSON Decode Error: " . json_last_error_msg());
            throw new Exception("Failed to decode JSON: " . json_last_error_msg());
        }

        return $data;
    }

    /** Prepare data for storage*/
    public function prepareForStorage($products) {
        if (!is_array($products)) {
            throw new Exception("Invalid products data format");
        }

        $prepared = [];
        
        foreach ($products as $product) {
            // Validate required fields
            if (!isset($product['id']) || !isset($product['title']) || !isset($product['price'])) {
                error_log("Skipping product with missing required fields: " . json_encode($product));
                continue;
            }

            $prepared[] = [
                'id' => (int)$product['id'],
                'title' => $product['title'],
                'price' => (float)$product['price'],
                'description' => $product['description'] ?? '',
                'category' => $product['category'] ?? '',
                'image' => $product['image'] ?? '',
                'rating' => [
                    'rate' => (float)($product['rating']['rate'] ?? 0),
                    'count' => (int)($product['rating']['count'] ?? 0)
                ]
            ];
        }

        return $prepared;
    }
}

