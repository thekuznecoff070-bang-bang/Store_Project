<section style="max-width:var(--max); margin:0 auto; padding:60px 18px;">

    <h1 style="margin-bottom:8px;">Каталог товаров</h1>
    <p style="color:var(--muted); margin-bottom:32px;">
        Всего: <?= count($products) ?>
        <?php
        $count = count($products);
        $lastDigit = $count % 10;
        $lastTwoDigits = $count % 100;

        if ($lastTwoDigits >= 11 && $lastTwoDigits <= 19) {
            echo 'товаров';
        } elseif ($lastDigit === 1) {
            echo 'товар';
        } elseif ($lastDigit >= 2 && $lastDigit <= 4) {
            echo 'товара';
        } else {
            echo 'товаров';
        }
        ?>
    </p>

    <?php if (empty($products)): ?>

        <div class="glass-card" style="padding:40px; text-align:center;">
            <p style="font-size:48px; margin-bottom:16px;">📦</p>
            <h2>Товаров пока нет</h2>
            <p style="color:var(--muted);">Загляните позже</p>
            <a href="/" class="btn btn--primary" style="margin-top:20px;">На главную</a>
        </div>

    <?php else: ?>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(300px, 1fr)); gap:24px;">

            <?php foreach ($products as $product): ?>
                <article class="glass-card" style="padding:24px; display:flex; flex-direction:column;">

                    <h3 class="glass-card__title" style="margin-bottom:8px;">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>

                    <!-- Описание товара (если есть) -->
                    <?php if (!empty($product['description'])): ?>
                        <p style="color:var(--muted); font-size:14px; margin:0 0 16px 0; flex-grow:1;">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                    <?php endif; ?>

                    <p style="font-size:24px; font-weight:700; margin:0 0 16px 0;">
                        <?= number_format((float)$product['price'], 0, '.', ' ') ?> ₽
                    </p>

                    <a href="/cart/add?id=<?= (int)$product['id'] ?>"
                       class="btn btn--primary"
                       style="display:block; text-align:center;">
                        🛒 В корзину
                    </a>

                </article>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>