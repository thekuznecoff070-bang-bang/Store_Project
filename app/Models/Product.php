<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

class Product
{
    public static function all(): array
    {
        $pdo = Database::connect();

        // Добавили description в SELECT
        $stmt = $pdo->query('SELECT id, name, description, price FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connect();

        // Добавили description в SELECT
        $stmt = $pdo->prepare('SELECT id, name, description, price FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        return $product ?: null;
    }
}