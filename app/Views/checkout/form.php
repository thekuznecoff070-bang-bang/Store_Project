<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="/css/styles.css"/>
</head>
<body>

<header class="topbar" role="banner">
    <nav class="nav">
        <a class="brand" href="/">
            <span class="brand__dot" aria-hidden="true"></span>
            <span class="brand__text">Store</span>
        </a>
        <div class="nav__links">
            <a class="nav__link" href="/cart">← Вернуться в корзину</a>
        </div>
    </nav>
</header>

<main class="page">
    <section style="max-width:600px; margin:0 auto; padding:60px 18px;">

        <h1 style="margin-bottom:8px;">📝 Оформление заказа</h1>
        <p style="color:var(--muted); margin-bottom:32px;">
            Заполните данные и мы свяжемся с вами для подтверждения
        </p>

        <?php
        // Достаём корзину из сессии
        $cart = $_SESSION['cart'] ?? [];
        $total = 0;
        ?>

        <?php if (empty($cart)): ?>

            <div class="glass-card" style="padding:40px; text-align:center;">
                <h2>Корзина пуста</h2>
                <p style="color:var(--muted);">Сначала добавьте товары</p>
                <a href="/products" class="btn btn--primary" style="margin-top:16px;">
                    В каталог
                </a>
            </div>

        <?php else: ?>

            <!-- Список товаров в заказе -->
            <div class="glass-card" style="padding:20px; margin-bottom:24px;">
                <h3 style="margin:0 0 16px 0;">Ваш заказ:</h3>

                <?php foreach ($cart as $item): ?>
                    <?php $itemTotal = $item['price'] * $item['qty']; ?>
                    <?php $total += $itemTotal; ?>

                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid var(--border);">
                    <span>
                        <?= htmlspecialchars($item['name']) ?>
                        × <?= (int)$item['qty'] ?>
                    </span>
                        <span style="font-weight:600;">
                        <?= number_format($itemTotal, 0, '.', ' ') ?> ₽
                    </span>
                    </div>
                <?php endforeach; ?>

                <div style="display:flex; justify-content:space-between; padding:16px 0 0; font-size:20px; font-weight:700;">
                    <span>Итого:</span>
                    <span><?= number_format($total, 0, '.', ' ') ?> ₽</span>
                </div>
            </div>

            <!-- Форма с данными покупателя -->
            <form method="POST" action="/checkout" class="glass-card" style="padding:24px;">

                <!-- CSRF-токен (скрытое поле) -->
                <input
                        type="hidden"
                        name="checkout_token"
                        value="<?= htmlspecialchars($_SESSION['checkout_token'] ?? '') ?>"
                />

                <!-- Поле: Имя -->
                <div style="margin-bottom:20px;">
                    <label for="customer_name"
                           style="display:block; margin-bottom:6px; font-weight:600;">
                        Ваше имя
                    </label>
                    <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            required
                            placeholder="Иван Иванов"
                            style="width:100%; padding:12px 16px; border:1px solid var(--border); border-radius:var(--radius-sm); background:var(--bg); color:var(--text); font-size:16px;"
                    />
                </div>

                <!-- Поле: Телефон -->
                <div style="margin-bottom:24px;">
                    <label for="customer_phone"
                           style="display:block; margin-bottom:6px; font-weight:600;">
                        Телефон
                    </label>
                    <input
                            type="tel"
                            id="customer_phone"
                            name="customer_phone"
                            required
                            placeholder="+7 (999) 123-45-67"
                            style="width:100%; padding:12px 16px; border:1px solid var(--border); border-radius:var(--radius-sm); background:var(--bg); color:var(--text); font-size:16px;"
                    />
                </div>

                <!-- Кнопка отправки -->
                <button type="submit" class="btn btn--primary"
                        style="width:100%; padding:14px; font-size:16px; cursor:pointer;">
                    Подтвердить заказ на <?= number_format($total, 0, '.', ' ') ?> ₽
                </button>

            </form>

        <?php endif; ?>

    </section>
</main>

</body>
</html>