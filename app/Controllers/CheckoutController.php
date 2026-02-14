<?php
declare(strict_types=1);

class CheckoutController
{
    public function form(): void
    {
        require_once __DIR__ . '/../Views/checkout.php';
    }

    public function submit(): void
    {
        require_once __DIR__ . '/../Core/Database.php';

        $name = $_POST['customer_name'] ?? '';
        $phone = $_POST['customer_phone'] ?? '';

        if ($name === '' || $phone === '') {
            echo 'Пожалуйста, заполните все поля.';
            return;
        }

        $pdo = Database::connect();

        $stmt = $pdo->prepare(
            'INSERT INTO orders (customer_name, customer_phone, total_price)VALUES (:name, :phone, :total)');
        $stmt->execute([
            'name' => $name,
            'phone' => $phone,
            'total' => 0.00,
        ]);

        $orderId = (int) $pdo->lastInsertId();

        echo 'Заказ #' . $orderId . ' сохранён';
    }
}