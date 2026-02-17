<?php
declare(strict_types=1);

class Order
{
    public static function create(array $data): int
    {
        require_once __DIR__ . '/../Core/Database.php';
        $db = Database::connect();

        $sql = "
            INSERT INTO orders (user_name, user_phone, total_price, created_at)
            VALUES (:user_name, :user_phone, :total_price, NOW())
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':user_name' => $data['user_name'],
            ':user_phone' => $data['user_phone'],
            ':total_price' => $data['total_price'],
        ]);

        return (int)$db->lastInsertId();
    }

    public static function findById(int $id): ?array
    {
        require_once __DIR__ . '/../Core/Database.php';
        $db = Database::connect();

        $stmt = $db->prepare('SELECT * FROM orders WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        return $order ?: null;
    }
}