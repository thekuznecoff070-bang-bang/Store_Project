<h1>Каталог товаров</h1>

<?php if (empty($products)): ?>
    <p>Товаров пока нет</p>
<?php else: ?>
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <strong><?= htmlspecialchars($product['name']) ?></strong>
                — <?= number_format((float)$product['price'], 2) ?> ₽
                <a href="/cart/add?id=<?= $product['id'] ?>">Добавить в корзину</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>