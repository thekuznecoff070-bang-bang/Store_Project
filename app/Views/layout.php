<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Магазин' ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>

<header>
    <nav>
        <a href="/">Главная</a> |
        <a href="/products">Товары</a>
    </nav>
</header>

<main>
    <?php require $content; ?>
</main>

<footer>
    <hr>
    <small>© <?= date('Y') ?> Магазин</small>
</footer>

<script src="/js/app.js"></script>
</body>
</html>
