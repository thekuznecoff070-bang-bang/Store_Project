<?php
declare(strict_types=1);

class OrderController
{
    public function success(): void
    {
        require_once __DIR__ . '/../Models/Order.php';
        require_once __DIR__ . '/../Models/OrderItem.php';


        $orderId = 0;
        if (isset($_GET['id'])) {
            $orderId = (int)$_GET['id'];
        } elseif (isset($_GET['order_id'])) {
            $orderId = (int)$_GET['order_id'];
        }

        $sessionOrderId = isset($_SESSION['success_order_id'])
            ? (int)$_SESSION['success_order_id']
            : 0;

        if ($orderId <= 0 || $sessionOrderId <= 0 || $sessionOrderId !== $orderId) {
            echo 'Доступ запрещен';
            return;
        }

        unset($_SESSION['success_order_id']); // Удаляем ID заказа из сессии, чтобы предотвратить повторный доступ

        $order = Order::findById($orderId);
        if (!$order) {
            require __DIR__ . '/../Views/checkout/not_found.php';
            return;
        }

        $items = OrderItem::getByOrderId($orderId); // Получаем товары заказа

        require __DIR__ . '/../Views/checkout/success.php';
    }
}
