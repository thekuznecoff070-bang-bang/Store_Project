<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= htmlspecialchars($title ?? 'Магазин') ?></title>
    <meta name="description" content="Store Project — интернет-магазин на PHP"/>
    <link rel="stylesheet" href="/css/styles.css"/>
</head>
<body>
<a class="skip-link" href="#main-content">Перейти к содержимому</a>

<header class="topbar" role="banner">
    <nav class="nav" aria-label="Основная навигация">
        <a class="brand" href="/" aria-label="Store Project — главная">
            <span class="brand__dot" aria-hidden="true"></span>
            <span class="brand__text">Store</span>
        </a>

        <div class="nav__links" role="navigation">
            <a class="nav__link" href="/">Главная</a>
            <a class="nav__link" href="/products">Каталог</a>
        </div>

        <div class="nav__actions">
            <button class="icon-btn" id="btnTheme" type="button" aria-label="Переключить тему">
                <span class="icon" aria-hidden="true">◐</span>
            </button>
            <a class="cart-btn" href="/cart">
                <span class="cart-btn__label">Корзина</span>
                <span class="cart-badge">
                    <?php
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

<main class="page" id="main-content">
    <?php require $content; ?>
</main>

<footer class="footer">
    <div class="footer__inner">
        <p class="footer__text">
            © <?= date('Y') ?> Store Project. PHP + MySQL.
        </p>
        <a class="footer__link" href="#main-content">Наверх</a>
    </div>
</footer>

<script src="/js/store.js"></script>
</body>
</html>
