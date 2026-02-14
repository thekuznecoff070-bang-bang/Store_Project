<h1>Спасибо за заказ!</h1>

<?php if (!empty($_SESSION['order_id'])): ?>
    <p>
        Ваш заказ №<?= (int)$_SESSION['order_id'] ?> успешно оформлен.
    </p>
<?php else: ?>
    <p>Заказ не найден.</p>
<?php endif; ?>

<?php unset($_SESSION['order_id']); ?>