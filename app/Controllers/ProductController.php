<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/Product.php';

class ProductController
{
    public function index(): void
    {
        $title = 'Товары';
        $products = Product::all();
        $content = __DIR__ . '/../Views/products.php';

        require __DIR__ . '/../Views/layout.php';
    }
}

