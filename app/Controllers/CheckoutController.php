<?php
declare(strict_types=1);

class CheckoutController
{
    public function form(): void
    {
        $_SESSION['checkout_token'] = bin2hex(random_bytes(16));
        require_once __DIR__ . '/../Views/checkout/form.php';
    }

    public function submit(): void
    {
        $token = $_POST['checkout_token'] ?? '';
        if (
            empty($_SESSION['checkout_token']) ||
            $token !== $_SESSION['checkout_token']
        ) {
            echo 'Заказ уже был отправлен или форма устарела';
            exit;
        }

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

            //  НАЧАЛИ ТРАНЗАКЦИЮ
            $pdo->beginTransaction();

            //  СОХРАНЯЕМ ЗАКАЗ (orders)
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

            //  СОХРАНЯЕМ ТОВАРЫ (order_items)
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

            //  ВСЁ ОК — ФИКСИРУЕМ
            $pdo->commit();
            unset($_SESSION['checkout_token']);
            unset($_SESSION['cart']);

            $_SESSION['success_order_id'] = $orderId;

            header('Location: /order/success?id=' . urldecode((string)$orderId));
            exit;

        } catch (Throwable $e) {

            //  ЕСЛИ ОШИБКА — ОТКАТ
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            echo 'Ошибка оформления заказа';
            exit;
        }

    }
}