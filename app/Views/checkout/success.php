<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Заказ оформлен!</title>
    <link rel="stylesheet" href="/css/styles.css"/>
</head>
<body>

<header class="topbar" role="banner">
    <nav class="nav">
        <a class="brand" href="/">
            <span class="brand__dot" aria-hidden="true"></span>
            <span class="brand__text">Store</span>
        </a>
    </nav>
</header>

<main class="page">
    <section style="max-width:600px; margin:0 auto; padding:60px 18px; text-align:center;">

        <!-- Иконка успеха -->
        <div style="font-size:64px; margin-bottom:16px;">✅</div>

        <h1 style="margin-bottom:8px;">Заказ оформлен!</h1>
        <p style="color:var(--muted); margin-bottom:32px;">
            Спасибо за покупку. Мы свяжемся с вами для подтверждения.
        </p>

        <!-- Информация о заказе -->
        <div class="glass-card" style="padding:24px; text-align:left; margin-bottom:24px;">

            <h3 style="margin:0 0 16px 0;">
                Заказ #<?= (int)$order['id'] ?>
            </h3>

            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border);">
                <span style="color:var(--muted);">Имя:</span>
                <span style="font-weight:600;">
                <?= htmlspecialchars($order['customer_name']) ?>
            </span>
            </div>

            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border);">
                <span style="color:var(--muted);">Телефон:</span>
                <span style="font-weight:600;">
                <?= htmlspecialchars($order['customer_phone']) ?>
            </span>
            </div>

            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border);">
                <span style="color:var(--muted);">Дата:</span>
                <span style="font-weight:600;">
                <?= htmlspecialchars($order['created_at']) ?>
            </span>
            </div>

            <!-- Товары в заказе -->
            <?php if (!empty($items)): ?>
                <h4 style="margin:20px 0 12px 0;">Товары:</h4>

                <?php foreach ($items as $item): ?>
                    <div style="display:flex; justify-content:space-between; padding:6px 0;">
                    <span>
                        <?= htmlspecialchars($item['name']) ?>
                        × <?= (int)$item['quantity'] ?>
                    </span>
                        <span style="font-weight:600;">
                        <?= number_format((float)$item['price'] * (int)$item['quantity'], 0, '.', ' ') ?> ₽
                    </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Итого -->
            <div style="display:flex; justify-content:space-between; padding:16px 0 0; margin-top:12px; border-top:2px solid var(--border); font-size:20px; font-weight:700;">
                <span>Итого:</span>
                <span><?= number_format((float)$order['total_price'], 0, '.', ' ') ?> ₽</span>
            </div>

        </div>

        <!-- Кнопка на главную -->
        <a href="/" class="btn btn--primary" style="display:inline-block;">
            На главную
        </a>

    </section>
</main>

</body>
</html>