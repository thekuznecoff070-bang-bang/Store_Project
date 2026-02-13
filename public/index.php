<!doctype html>
<html lang="ru">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Store Project</title>
    <meta
      name="description"
      content="Демо магазина: каталог, корзина, оформление заказа. Vanilla HTML/CSS/JS."
    />

    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <a class="skip-link" href="#catalog">Перейти к каталогу</a>

    <header class="topbar" role="banner">
      <nav class="nav" aria-label="Основная навигация">
        <a class="brand" href="index.php" aria-label="Store Project — главная">
          <span class="brand__dot" aria-hidden="true"></span>
          <span class="brand__text">Store</span>
        </a>

        <div class="nav__links" role="navigation">
          <a class="nav__link" href="#catalog">Каталог</a>
          <a class="nav__link" href="#how">Доставка</a>
          <a class="nav__link" href="#faq">FAQ</a>
        </div>

        <div class="nav__actions">
          <button class="icon-btn" id="btnTheme" type="button" aria-label="Переключить тему">
            <span class="icon" aria-hidden="true">◐</span>
          </button>
          <button class="cart-btn" id="btnCart" type="button" aria-haspopup="dialog">
            <span class="cart-btn__label">Корзина</span>
            <span class="cart-badge" id="cartBadge" aria-label="Товаров в корзине">0</span>
          </button>
        </div>
      </nav>
    </header>

    <main class="page" id="top">
      <section class="hero" aria-label="Презентация магазина">
        <div class="hero__inner">
          <p class="eyebrow">Store Project</p>
          <h1 class="hero__title">Техника, которой приятно пользоваться.</h1>
          <p class="hero__subtitle">
            Каталог, корзина, оформление. Онлайн-оплату подключим позже на PHP.
          </p>

          <div class="hero__cta">
            <a class="btn btn--primary" href="#catalog">Смотреть каталог</a>
            <button class="btn btn--ghost" id="btnQuickAdd" type="button">
              Быстро добавить бестселлер
            </button>
          </div>

          <div class="hero__cards" aria-label="Преимущества">
            <article class="glass-card">
              <h3 class="glass-card__title">Быстро</h3>
              <p class="glass-card__text">Рендер каталога и корзины на чистом JavaScript.</p>
            </article>
            <article class="glass-card">
              <h3 class="glass-card__title">Чисто</h3>
              <p class="glass-card__text">Минималистичный UI в стиле apple.com.</p>
            </article>
            <article class="glass-card">
              <h3 class="glass-card__title">Готово к PHP</h3>
              <p class="glass-card__text">Checkout и “оплата” как точки интеграции.</p>
            </article>
          </div>
        </div>
      </section>

      <section class="section" id="catalog" aria-label="Каталог товаров">
        <div class="section__header">
          <h2 class="section__title">Каталог</h2>
          <div class="section__tools">
            <label class="field field--compact" for="search">
              <span class="field__label">Поиск</span>
              <input
                id="search"
                class="input"
                type="search"
                placeholder="Например: Air, Pro, Dock…"
                autocomplete="off"
              />
            </label>
            <label class="field field--compact" for="sort">
              <span class="field__label">Сортировка</span>
              <select id="sort" class="select">
                <option value="featured">Рекомендуем</option>
                <option value="price-asc">Цена: по возрастанию</option>
                <option value="price-desc">Цена: по убыванию</option>
                <option value="name-asc">Название: A → Я</option>
              </select>
            </label>
          </div>
        </div>

        <div class="product-grid" id="productGrid" aria-live="polite"></div>
      </section>

      <section class="section" id="how" aria-label="Доставка и возврат">
        <div class="split">
          <div class="split__left">
            <h2 class="section__title">Доставка и возврат</h2>
            <p class="muted">
              Это демо. Здесь — пример контента и места для политики доставки/возврата.
            </p>
          </div>
          <div class="split__right">
            <div class="info-list">
              <div class="info">
                <h3 class="info__title">Доставка</h3>
                <p class="info__text">1–3 дня по городу, 3–7 дней по стране.</p>
              </div>
              <div class="info">
                <h3 class="info__title">Гарантия</h3>
                <p class="info__text">12 месяцев. Обмен/возврат в течение 14 дней.</p>
              </div>
              <div class="info">
                <h3 class="info__title">Поддержка</h3>
                <p class="info__text">Почта, чат, телефон — добавим позже.</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="section" id="faq" aria-label="Вопросы и ответы">
        <h2 class="section__title">FAQ</h2>
        <div class="faq">
          <details class="faq__item">
            <summary class="faq__q">Это настоящий магазин?</summary>
            <div class="faq__a">
              Нет, это фронтенд-демо. Интеграции (заказы/оплата) подключим на PHP.
            </div>
          </details>
          <details class="faq__item">
            <summary class="faq__q">Где хранится корзина?</summary>
            <div class="faq__a">В браузере, через <code>localStorage</code>.</div>
          </details>
          <details class="faq__item">
            <summary class="faq__q">Можно ли подключить оплату?</summary>
            <div class="faq__a">
              Да. Сейчас стоит “заглушка” на JS, а затем заменим на ваш PHP-обработчик.
            </div>
          </details>
        </div>
      </section>
    </main>

    <footer class="footer">
      <div class="footer__inner">
        <p class="footer__text">
          © <span id="year"></span> Store Project. Vanilla HTML/CSS/JS.
        </p>
        <a class="footer__link" href="#top">Наверх</a>
      </div>
    </footer>

    <!-- Drawer: Cart -->
    <div class="backdrop" id="backdrop" hidden></div>
    <aside class="drawer" id="drawer" role="dialog" aria-modal="true" aria-label="Корзина" hidden>
      <div class="drawer__header">
        <div>
          <h2 class="drawer__title">Корзина</h2>
          <p class="drawer__subtitle" id="drawerSubtitle">0 товаров</p>
        </div>
        <button class="icon-btn" id="btnCloseCart" type="button" aria-label="Закрыть корзину">
          <span class="icon" aria-hidden="true">×</span>
        </button>
      </div>

      <div class="drawer__body">
        <div class="cart" id="cartItems"></div>
        <div class="empty" id="cartEmpty" hidden>
          <p class="empty__title">Корзина пустая</p>
          <p class="empty__text">Добавьте что‑нибудь из каталога — и оформим заказ.</p>
          <a class="btn btn--primary" href="#catalog" id="btnGoCatalog">Перейти к каталогу</a>
        </div>
      </div>

      <div class="drawer__footer">
        <div class="totals">
          <div class="totals__row">
            <span class="muted">Подытог</span>
            <span id="subtotal">0 ₽</span>
          </div>
          <div class="totals__row">
            <span class="muted">Доставка</span>
            <span id="shipping">0 ₽</span>
          </div>
          <div class="totals__row totals__row--total">
            <span>Итого</span>
            <span id="total">0 ₽</span>
          </div>
        </div>

        <div class="drawer__actions">
          <button class="btn btn--ghost" id="btnClearCart" type="button">Очистить</button>
          <button class="btn btn--primary" id="btnCheckout" type="button">
            Оформить заказ
          </button>
        </div>
      </div>
    </aside>

    <!-- Modal: Checkout -->
    <div class="modal" id="checkoutModal" role="dialog" aria-modal="true" aria-label="Оформление заказа" hidden>
      <div class="modal__panel" role="document">
        <div class="modal__header">
          <div>
            <h2 class="modal__title">Оформление</h2>
            <p class="modal__subtitle">Почти готово. Заполните данные и перейдём к оплате.</p>
          </div>
          <button class="icon-btn" id="btnCloseCheckout" type="button" aria-label="Закрыть оформление">
            <span class="icon" aria-hidden="true">×</span>
          </button>
        </div>

        <form class="form" id="checkoutForm" novalidate>
          <div class="grid-2">
            <label class="field" for="name">
              <span class="field__label">Имя</span>
              <input class="input" id="name" name="name" type="text" required minlength="2" />
              <span class="field__hint">Как к вам обращаться</span>
            </label>

            <label class="field" for="phone">
              <span class="field__label">Телефон</span>
              <input class="input" id="phone" name="phone" type="tel" required placeholder="+7..." />
              <span class="field__hint">Для уточнения доставки</span>
            </label>
          </div>

          <label class="field" for="email">
            <span class="field__label">Email</span>
            <input class="input" id="email" name="email" type="email" required placeholder="you@example.com" />
            <span class="field__hint">Туда отправим чек/статус</span>
          </label>

          <label class="field" for="address">
            <span class="field__label">Адрес</span>
            <input class="input" id="address" name="address" type="text" required minlength="6" placeholder="Город, улица, дом, квартира" />
            <span class="field__hint">Для доставки</span>
          </label>

          <div class="grid-2">
            <label class="field" for="delivery">
              <span class="field__label">Доставка</span>
              <select class="select" id="delivery" name="delivery" required>
                <option value="pickup">Самовывоз — бесплатно</option>
                <option value="courier" selected>Курьер — 399 ₽</option>
              </select>
              <span class="field__hint">Стоимость пересчитается</span>
            </label>

            <label class="field" for="payment">
              <span class="field__label">Оплата</span>
              <select class="select" id="payment" name="payment" required>
                <option value="online" selected>Онлайн (заглушка)</option>
                <option value="card-on-delivery">Картой при получении</option>
              </select>
              <span class="field__hint">Позже подключим реальный провайдер</span>
            </label>
          </div>

          <div class="form__summary">
            <div class="summary">
              <div class="summary__row">
                <span class="muted">К оплате</span>
                <span class="summary__total" id="checkoutTotal">0 ₽</span>
              </div>
              <p class="muted summary__note">
                Нажимая “Перейти к оплате”, вы создаёте демо‑заказ (в реальном проекте отправим на PHP).
              </p>
            </div>
          </div>

          <div class="form__actions">
            <button class="btn btn--ghost" id="btnBackToCart" type="button">Назад</button>
            <button class="btn btn--primary" type="submit">Перейти к оплате</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal: Payment Stub -->
    <div class="modal" id="paymentModal" role="dialog" aria-modal="true" aria-label="Онлайн оплата" hidden>
      <div class="modal__panel" role="document">
        <div class="modal__header">
          <div>
            <h2 class="modal__title">Онлайн‑оплата</h2>
            <p class="modal__subtitle">Заглушка. Здесь позже будет редирект на платёжную систему.</p>
          </div>
          <button class="icon-btn" id="btnClosePayment" type="button" aria-label="Закрыть оплату">
            <span class="icon" aria-hidden="true">×</span>
          </button>
        </div>

        <div class="pay-stub">
          <div class="pay-stub__card">
            <p class="muted">Сумма</p>
            <p class="pay-stub__amount" id="payAmount">0 ₽</p>
            <div class="pay-stub__line"></div>
            <p class="muted">Заказ</p>
            <p class="pay-stub__order" id="payOrderId">—</p>
          </div>

          <div class="pay-stub__actions">
            <button class="btn btn--ghost" id="btnPayCancel" type="button">Отменить</button>
            <button class="btn btn--primary" id="btnPaySuccess" type="button">
              Оплачено (демо)
            </button>
          </div>
        </div>
      </div>
    </div>

    <script src="app.js" defer></script>
  </body>
</html>
