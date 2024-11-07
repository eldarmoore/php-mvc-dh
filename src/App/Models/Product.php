<?php

declare(strict_types=1);

namespace App\Models;

use App\Database;
use PDO;

class Product
{
    public function __construct(private Database $database)
    {

    }

    public function getData(): array
    {
        $pdo = $this->database->getConnection();

        $stmt = $pdo->query("SELECT * FROM product");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array
    {
        $conn = $this->database->getConnection();

        $sql = "SELECT * FROM product WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}