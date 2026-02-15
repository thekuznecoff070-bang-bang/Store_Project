<h1>Спасибо за заказ!</h1>

<p>
    <strong>Номер заказа:</strong> <?= (int)$order['id'] ?><br>
    <strong>Сумма:</strong> <?= (float)$order['total_price'] ?> ₽
</p>

<h2>Состав заказа</h2>

<ul>
    <?php foreach ($items as $item): ?>
        <li>
            <?= htmlspecialchars($item['name']) ?> —
            <?= (int)$item['quantity'] ?> ×
            <?= (float)$item['price'] ?> ₽
        </li>
    <?php endforeach; ?>
</ul>
