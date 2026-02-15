<?php
declare(strict_types=1);

class OrderItem
{
    public static function getByOrderId(int $orderId): array
    {
        require_once __DIR__ . '/../Core/Database.php';
        $db = Database::connect();

        $sql = "
            SELECT 
                oi.quantity,
                oi.price,
                p.name
            FROM order_items oi
            JOIN products p ON p.id = oi.product_id
            WHERE oi.order_id = :order_id
        ";
        $stmt = $db->prepare($sql);
        $stmt->execute([':order_id' => $orderId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}