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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Products</title>
    <meta charset="UTF-8">
</head>
<body>

<h1>Products</h1>

<?php foreach ($products as $product): ?>

    <h2><?= htmlspecialchars($product["name"]) ?></h2>
    <p><?= htmlspecialchars($product["description"]) ?></p>

<?php endforeach; ?>

</body>
</html>