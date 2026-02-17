<section style="max-width:var(--max); margin:0 auto; padding:60px 18px;">

    <h1 style="margin-bottom:32px;">🛒 Корзина</h1>

    <?php if (empty($cart)): ?>

        <!-- Корзина пуста -->
        <div class="glass-card" style="padding:40px; text-align:center;">
            <p style="font-size:48px; margin-bottom:16px;">🛒</p>
            <h2>Корзина пуста</h2>
            <p style="color:var(--muted); margin-bottom:20px;">
                Добавьте товары из каталога
            </p>
            <a href="/products" class="btn btn--primary">Перейти в каталог</a>
        </div>

    <?php else: ?>

        <?php $total = 0; ?>

        <!-- Список товаров в корзине -->
        <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:32px;">

            <?php foreach ($cart as $id => $item): ?>
                <?php
                // Считаем стоимость этой позиции
                $itemTotal = $item['price'] * $item['qty'];
                // Прибавляем к общей сумме
                $total += $itemTotal;
                ?>

                <div class="glass-card"
                     style="padding:20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">

                    <!-- Левая часть: название и цена за штуку -->
                    <div>
                        <h3 style="margin:0 0 4px 0;">
                            <?= htmlspecialchars($item['name']) ?>
                        </h3>
                        <p style="color:var(--muted); margin:0; font-size:14px;">
                            <?= number_format((float)$item['price'], 0, '.', ' ') ?> ₽ за шт.
                        </p>
                    </div>

                    <!-- Средняя часть: количество и сумма -->
                    <div style="text-align:center;">
                        <p style="margin:0; font-size:14px; color:var(--muted);">
                            Кол-во: <?= (int)$item['qty'] ?>
                        </p>
                        <p style="margin:4px 0 0; font-size:18px; font-weight:700;">
                            <?= number_format($itemTotal, 0, '.', ' ') ?> ₽
                        </p>
                    </div>

                    <!-- Правая часть: кнопка удалить -->
                    <a href="/cart/remove?id=<?= (int)$id ?>"
                       style="color:var(--danger); font-size:14px; text-decoration:none; padding:8px 16px; border:1px solid var(--danger); border-radius:var(--radius-sm);">
                        ✕ Удалить
                    </a>

                </div>

            <?php endforeach; ?>

        </div>

        <!-- Блок с итогом -->
        <div class="glass-card"
             style="padding:24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:16px;">

            <div>
                <p style="color:var(--muted); margin:0; font-size:14px;">Итого к оплате:</p>
                <p style="margin:4px 0 0; font-size:28px; font-weight:700;">
                    <?= number_format($total, 0, '.', ' ') ?> ₽
                </p>
            </div>

            <div style="display:flex; gap:12px; flex-wrap:wrap;">
                <a href="/products" class="btn btn--ghost"
                   style="display:inline-block; text-align:center;">
                    ← Продолжить покупки
                </a>
                <a href="/checkout" class="btn btn--primary"
                   style="display:inline-block; text-align:center;">
                    Оформить заказ →
                </a>
            </div>

        </div>

    <?php endif; ?>

</section>
