<?php
declare(strict_types=1);

class CheckoutController
{
    public function form(): void
    {
        require_once __DIR__ . '/../Views/checkout/form.php';
    }

    public function submit(): void
    {
        require_once __DIR__ . '/../Core/Database.php';

        $name = $_POST['customer_name'] ?? '';
        $phone = $_POST['customer_phone'] ?? '';

        if ($name === '' || $phone === '') {
            header('Location: /checkout');
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            header('Location: /cart');
            exit;
        }

        $pdo = Database::connect();

        // 1. Создаём заказ
        $stmt = $pdo->prepare(
            'INSERT INTO orders (customer_name, customer_phone, total_price)
         VALUES (:name, :phone, :total)'
        );
        $stmt->execute([
            'name' => $name,
            'phone' => $phone,
            'total' => 0.00,
        ]);

        $orderId = (int)$pdo->lastInsertId();
        $_SESSION['order_id'] = $orderId;

        // 2. Сохраняем товары заказа
        $stmtItem = $pdo->prepare(
            'INSERT INTO order_items (order_id, product_id, price, quantity)
         VALUES (:order_id, :product_id, :price, :quantity)'
        );

        foreach ($cart as $item) {
            $stmtItem->execute([
                'order_id' => $orderId,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['qty'],
            ]);
        }

        // 3. Редирект
        header('Location: /order/success');
        exit;
    }

}