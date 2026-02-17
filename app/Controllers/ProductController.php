<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/Product.php';

class ProductController
{
    public function index(): void
    {
        // Получаем параметры из URL (?search=...&sort=...)
        $search = trim($_GET['search'] ?? '');
        $sort = $_GET['sort'] ?? 'default';

        // Разрешённые варианты сортировки (защита от подмены)
        $allowedSorts = ['default', 'price-asc', 'price-desc', 'name-asc'];
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'default';
        }

        // Ищем товары через модель
        $products = Product::search($search, $sort);

        $title = 'Каталог товаров';
        $content = __DIR__ . '/../Views/products.php';
        require __DIR__ . '/../Views/layout.php';
    }
}
