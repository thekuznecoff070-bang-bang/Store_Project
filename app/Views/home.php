<!-- ===== HERO ===== -->
<section class="hero" aria-label="Презентация магазина">
    <div class="hero__inner">
        <p class="eyebrow">Store Project</p>
        <h1 class="hero__title">Техника, которой приятно пользоваться.</h1>
        <p class="hero__subtitle">
            Каталог, корзина, оформление заказа — всё работает на PHP + MySQL.
        </p>

        <div class="hero__cta">
            <a class="btn btn--primary" href="/products">Смотреть каталог</a>
        </div>

        <div class="hero__cards" aria-label="Преимущества">
            <article class="glass-card">
                <h3 class="glass-card__title">Быстро</h3>
                <p class="glass-card__text">Товары загружаются из базы данных MySQL.</p>
            </article>
            <article class="glass-card">
                <h3 class="glass-card__title">Безопасно</h3>
                <p class="glass-card__text">Защита от XSS, CSRF-токены, подготовленные запросы.</p>
            </article>
            <article class="glass-card">
                <h3 class="glass-card__title">Чисто</h3>
                <p class="glass-card__text">Архитектура MVC: Модель → Контроллер → Вид.</p>
            </article>
        </div>
    </div>
</section>

<!-- ===== ПОПУЛЯРНЫЕ ТОВАРЫ ===== -->
<?php
require_once __DIR__ . '/../Models/Product.php';
$featuredProducts = Product::all();
?>

<?php if (!empty($featuredProducts)): ?>
    <section class="section" aria-label="Популярные товары">
        <h2 class="section__title">🔥 Популярные товары</h2>

        <div class="product-grid" style="margin-top:20px;">
            <?php
            // Показываем максимум 3 товара на главной
            $shown = 0;
            foreach ($featuredProducts as $product):
                if ($shown >= 3) break;
                $shown++;
                ?>
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

        <?php if (count($featuredProducts) > 3): ?>
            <div style="text-align:center; margin-top:20px;">
                <a href="/products" class="btn btn--ghost">
                    Смотреть все <?= count($featuredProducts) ?> товаров →
                </a>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>

<!-- ===== ДОСТАВКА И ВОЗВРАТ ===== -->
<section class="section" id="how" aria-label="Доставка и возврат">
    <div class="split">
        <div class="split__left">
            <h2 class="section__title">Доставка и возврат</h2>
            <p class="muted">
                Мы доставляем по всей стране. Оплата при получении или онлайн.
            </p>
        </div>
        <div class="split__right">
            <div class="info-list">
                <div class="info">
                    <h3 class="info__title">📦 Доставка</h3>
                    <p class="info__text">1–3 дня по городу, 3–7 дней по стране. Курьер — 399 ₽, самовывоз — бесплатно.</p>
                </div>
                <div class="info">
                    <h3 class="info__title">🛡️ Гарантия</h3>
                    <p class="info__text">12 месяцев на всю технику. Обмен или возврат в течение 14 дней.</p>
                </div>
                <div class="info">
                    <h3 class="info__title">💬 Поддержка</h3>
                    <p class="info__text">Почта, чат, телефон — ответим в течение часа в рабочее время.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FAQ ===== -->
<section class="section" id="faq" aria-label="Вопросы и ответы">
    <h2 class="section__title">Частые вопросы</h2>
    <div class="faq">
        <details class="faq__item">
            <summary class="faq__q">Как оформить заказ?</summary>
            <div class="faq__a">
                Выберите товары в <a href="/products" style="color:var(--accent);">каталоге</a>,
                добавьте в корзину, перейдите к оформлению и заполните данные. Всё!
            </div>
        </details>
        <details class="faq__item">
            <summary class="faq__q">Где хранится корзина?</summary>
            <div class="faq__a">
                В сессии на сервере (<code>$_SESSION</code>). Данные хранятся, пока вы не закроете браузер
                или пока сессия не истечёт.
            </div>
        </details>
        <details class="faq__item">
            <summary class="faq__q">Можно ли подключить оплату?</summary>
            <div class="faq__a">
                Да. Сейчас заказ сохраняется в базу MySQL. В будущем можно подключить
                платёжную систему (ЮKassa, Stripe и т.д.) через PHP.
            </div>
        </details>
        <details class="faq__item">
            <summary class="faq__q">На чём работает магазин?</summary>
            <div class="faq__a">
                PHP 8 + MySQL 8 + чистый CSS/HTML. Архитектура MVC: модели работают с базой,
                контроллеры обрабатывают логику, виды отображают HTML.
            </div>
        </details>
    </div>
</section>