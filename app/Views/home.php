<section class="hero" aria-label="Презентация магазина">
    <div class="hero__inner">
        <p class="eyebrow">Store Project</p>
        <h1 class="hero__title">Техника, которой приятно пользоваться.</h1>
        <p class="hero__subtitle">
            Каталог, корзина, оформление заказа — всё работает на PHP.
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

<?php
// Подключаем модель Product, чтобы получить товары из БД
require_once __DIR__ . '/../Models/Product.php';

// Получаем ВСЕ товары из базы данных
$featuredProducts = Product::all();
?>

<?php if (!empty($featuredProducts)): ?>
    <section style="max-width:var(--max); margin:0 auto; padding:40px 18px;">
        <h2 style="margin-bottom:24px;">🔥 Популярные товары</h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
            <?php foreach ($featuredProducts as $product): ?>
                <article class="glass-card" style="padding:24px;">
                    <h3 class="glass-card__title">
                        <?= htmlspecialchars($product['name']) ?>
                    </h3>
                    <p class="glass-card__text" style="font-size:22px; font-weight:600; margin:12px 0;">
                        <?= number_format((float)$product['price'], 0, '.', ' ') ?> ₽
                    </p>
                    <a href="/cart/add?id=<?= $product['id'] ?>"
                       class="btn btn--primary"
                       style="display:inline-block; text-align:center;">
                        В корзину
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
