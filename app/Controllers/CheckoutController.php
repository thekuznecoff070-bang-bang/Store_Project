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
        // 1. Подключаемся к БД
        $pdo = Database::connect();

        try {
            // Считаем общую стоимость заказа
            $totalPrice = 0;
            foreach ($cart as $item) {
                $totalPrice += $item['price'] * $item['qty'];
            }

            // 1️⃣ НАЧАЛИ ТРАНЗАКЦИЮ
            $pdo->beginTransaction();

            // 2️⃣ СОХРАНЯЕМ ЗАКАЗ (orders)
            $stmt = $pdo->prepare(
                'INSERT INTO orders (customer_name, customer_phone, total_price)
         VALUES (:name, :phone, :total)'
            );
            $stmt->execute([
                'name' => $name,
                'phone' => $phone,
                'total' => $totalPrice,
            ]);

            $orderId = (int)$pdo->lastInsertId();

            // 3️⃣ СОХРАНЯЕМ ТОВАРЫ (order_items)
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

            // 4️⃣ ВСЁ ОК — ФИКСИРУЕМ
            $pdo->commit();

            // 5️⃣ ТОЛЬКО ТЕПЕРЬ чистим корзину
            unset($_SESSION['cart']);

            header('Location: /order/success?id=' . $orderId);
            exit;

        } catch (Throwable $e) {

            // 6️⃣ ЕСЛИ ОШИБКА — ОТКАТ
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            echo 'Ошибка оформления заказа';
            exit;
        }

    }
}