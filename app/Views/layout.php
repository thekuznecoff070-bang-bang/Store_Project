<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($title ?? 'Магазин') ?></title>
    <link rel="stylesheet" href="/css/styles.css"/>
</head>
<body>

<header class="topbar" role="banner">
    <nav class="nav" aria-label="Основная навигация">
        <!-- Логотип — ведёт на главную -->
        <a class="brand" href="/" aria-label="Store Project — главная">
            <span class="brand__dot" aria-hidden="true"></span>
            <span class="brand__text">Store</span>
        </a>

        <!-- Ссылки навигации -->
        <div class="nav__links" role="navigation">
            <a class="nav__link" href="/">Главная</a>
            <a class="nav__link" href="/products">Каталог</a>
        </div>

        <!-- Кнопка корзины -->
        <div class="nav__actions">
            <a class="cart-btn" href="/cart">
                <span class="cart-btn__label">Корзина</span>
                <span class="cart-badge">
                    <?php
                    // Считаем количество товаров в корзине из сессии
                    $cartCount = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $cartCount += $item['qty'];
                        }
                    }
                    echo $cartCount;
                    ?>
                </span>
            </a>
        </div>
    </nav>
</header>

<main class="page">
    <?php require $content; ?>
</main>

<footer style="text-align:center; padding:40px 20px; color:var(--muted); font-size:14px;">
    <hr style="border:none; border-top:1px solid var(--border); margin-bottom:20px;">
    <small>© <?= date('Y') ?> Store Project</small>
</footer>

<script src="/js/app.js"></script>
</body>
</html>