<?php

// Data Source Name (DSN) with explicit port number
$dsn = "mysql:host=localhost;dbname=product_db;charset=utf8;port=3306";

// Create PDO instance with database credentials and error mode setting
$pdo = new PDO($dsn, "product_db_user", "secret", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);

// SQL query to select all records from the 'product' table
$stmt = $pdo->query("SELECT * FROM product");

// Fetch all records as an associative array
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Print the result
print_r($products);