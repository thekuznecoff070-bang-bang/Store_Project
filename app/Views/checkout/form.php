<h1>Оформление заказа</h1>

<form method="post" action="/checkout">
    <div>
        <label>Имя</label><br>
        <input type="text" name="customer_name" required>
    </div>

    <div>
        <label>Телефон</label><br>
        <input type="text" name="customer_phone" required>
    </div>

    <input type="hidden" name="checkout_token"
           value="<?= htmlspecialchars($_SESSION['checkout_token']) ?>">

    <button type="submit">Оформить заказ</button>
</form>
