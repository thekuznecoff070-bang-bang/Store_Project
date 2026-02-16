<section class="section" id="catalog" aria-label="Каталог товаров">

    <!-- Заголовок + поиск + сортировка -->
    <div class="section__header">
        <h2 class="section__title">Каталог</h2>

        <div class="section__tools">
            <form method="GET" action="/products" style="display:flex; gap:10px; flex-wrap:wrap;">

                <!-- Поле поиска -->
                <label class="field field--compact" for="search">
                    <span class="field__label">Поиск</span>
                    <input
                            id="search"
                            class="input"
                            type="search"
                            name="search"
                            placeholder="Например: Air, Pro, Dock…"
                            value="<?= htmlspecialchars($search ?? '') ?>"
                            autocomplete="off"
                    />
                </label>

                <!-- Сортировка -->
                <label class="field field--compact" for="sort">
                    <span class="field__label">Сортировка</span>
                    <select id="sort" class="select" name="sort" onchange="this.form.submit()">
                        <option value="default"    <?= ($sort ?? '') === 'default'    ? 'selected' : '' ?>>По умолчанию</option>
                        <option value="price-asc"  <?= ($sort ?? '') === 'price-asc'  ? 'selected' : '' ?>>Цена: по возрастанию</option>
                        <option value="price-desc" <?= ($sort ?? '') === 'price-desc' ? 'selected' : '' ?>>Цена: по убыванию</option>
                        <option value="name-asc"   <?= ($sort ?? '') === 'name-asc'   ? 'selected' : '' ?>>Название: А → Я</option>
                    </select>
                </label>

                <!-- Кнопка поиска -->
                <div style="display:flex; align-items:flex-end;">
                    <button type="submit" class="btn btn--primary btn--mini">Найти</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Результат поиска -->
    <?php if (!empty($search)): ?>
        <p style="margin:16px 0 0; color:var(--muted); font-size:14px;">
            Результаты по запросу «<?= htmlspecialchars($search) ?>» —
            <?= count($products) ?>
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
            <a href="/products" style="color:var(--accent); margin-left:8px;">Сбросить</a>
        </p>
    <?php endif; ?>

    <!-- Товары -->
    <?php if (empty($products)): ?>

        <div class="empty" style="margin-top:20px;">
            <p class="empty__title">Ничего не найдено</p>
            <p class="empty__text">Попробуйте другой запрос или очистите поиск.</p>
            <a href="/products" class="btn btn--ghost">Сбросить поиск</a>
        </div>

    <?php else: ?>

        <div class="product-grid" style="margin-top:20px;">

            <?php foreach ($products as $product): ?>
                <article class="product">

                    <div class="product__top">
                        <span class="pill">
                            <?= number_format((float)$product['price'], 0, '.', ' ') ?> ₽
                        </span>
                    </div>

                    <h3 class="product__name">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>

                    <?php if (!empty($product['description'])): ?>
                        <p class="product__desc">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                    <?php endif; ?>

                    <div class="product__bottom">
                        <div class="price">
                            <?= number_format((float)$product['price'], 0, '.', ' ') ?> ₽
                        </div>
                        <div class="product__actions">
                            <a href="/cart/add?id=<?= (int)$product['id'] ?>"
                               class="btn btn--primary btn--mini">
                                В корзину
                            </a>
                        </div>
                    </div>

                </article>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</section>