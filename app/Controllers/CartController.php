<?php

declare(strict_types=1);

class CartController
{
    public function index(): void
    {
        $title = 'Корзина';
        $cart = $_SESSION['cart'] ?? [];
        $content = __DIR__ . '/../Views/cart.php';

        require __DIR__ . '/../Views/layout.php';
    }

    public function add(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            header('Location: /products');
            exit;
        }

        require_once __DIR__ . '/../Models/Product.php';
        $product = Product::find($id);

        if (!$product) {
            header('Location: /products');
            exit;
        }

        if (!isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'qty' => 1
            ];
        } else {
            $_SESSION['cart'][$id]['qty']++;
        }

        header('Location: /cart');
        exit;
    }

    public function remove(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        unset($_SESSION['cart'][$id]);

        header('Location: /cart');
        exit;
    }
}
