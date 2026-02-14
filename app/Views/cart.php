
<h1>Корзина</h1>

<?php if (empty($cart)): ?>
    <p>Корзина пуста</p>
<?php else: ?>
    <ul>
        <?php $total = 0; ?>
        <?php foreach ($cart as $item): ?>
            <?php $total += $item['price'] * $item['qty']; ?>
            <li>
                <?= htmlspecialchars($item['name']) ?>
                (<?= $item['qty'] ?> × <?= $item['price'] ?> ₽)
                <a href="/cart/remove?id=<?= $item['id'] ?>">✕</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <p><strong>Итого:</strong> <?= $total ?> ₽</p>
<?php endif; ?>