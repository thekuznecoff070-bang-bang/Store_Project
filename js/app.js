/* Store_Project: vanilla catalog + cart + checkout stub */

const STORAGE_KEYS = {
  cart: "store_project_cart_v1",
  theme: "store_project_theme_v1",
};

/** @type {{id:string,name:string,desc:string,tag:string,price:number,featured?:boolean}[]} */
const PRODUCTS = [
  {
    id: "airbuds-2",
    name: "AirBuds 2",
    desc: "Лёгкие наушники с чистым звуком и низкой задержкой.",
    tag: "Audio",
    price: 8990,
    featured: true,
  },
  {
    id: "airbuds-pro",
    name: "AirBuds Pro",
    desc: "Шумоподавление, режим прозрачности и плотная посадка.",
    tag: "Audio",
    price: 15990,
    featured: true,
  },
  {
    id: "watch-lite",
    name: "Watch Lite",
    desc: "Сон, активность, уведомления. Автономность до 7 дней.",
    tag: "Wearable",
    price: 12990,
  },
  {
    id: "dock-magsnap",
    name: "Dock MagSnap",
    desc: "Минималистичная док-станция для телефона и наушников.",
    tag: "Accessories",
    price: 6990,
  },
  {
    id: "keyboard-slim",
    name: "Keyboard Slim",
    desc: "Тихий ход, алюминиевый корпус, Bluetooth + USB‑C.",
    tag: "Accessories",
    price: 9990,
  },
  {
    id: "screen-27",
    name: "Display 27”",
    desc: "Тонкие рамки, точные цвета, комфорт для глаз.",
    tag: "Display",
    price: 44990,
  },
];

/** @type {Record<string, number>} */
let cart = loadCart();

const els = {
  year: document.getElementById("year"),
  btnCart: document.getElementById("btnCart"),
  btnCloseCart: document.getElementById("btnCloseCart"),
  btnClearCart: document.getElementById("btnClearCart"),
  btnCheckout: document.getElementById("btnCheckout"),
  btnGoCatalog: document.getElementById("btnGoCatalog"),
  btnQuickAdd: document.getElementById("btnQuickAdd"),
  cartBadge: document.getElementById("cartBadge"),
  drawer: document.getElementById("drawer"),
  backdrop: document.getElementById("backdrop"),
  cartItems: document.getElementById("cartItems"),
  cartEmpty: document.getElementById("cartEmpty"),
  drawerSubtitle: document.getElementById("drawerSubtitle"),
  subtotal: document.getElementById("subtotal"),
  shipping: document.getElementById("shipping"),
  total: document.getElementById("total"),
  productGrid: document.getElementById("productGrid"),
  search: document.getElementById("search"),
  sort: document.getElementById("sort"),
  btnTheme: document.getElementById("btnTheme"),
  checkoutModal: document.getElementById("checkoutModal"),
  btnCloseCheckout: document.getElementById("btnCloseCheckout"),
  btnBackToCart: document.getElementById("btnBackToCart"),
  checkoutForm: document.getElementById("checkoutForm"),
  checkoutTotal: document.getElementById("checkoutTotal"),
  delivery: document.getElementById("delivery"),
  payment: document.getElementById("payment"),
  paymentModal: document.getElementById("paymentModal"),
  btnClosePayment: document.getElementById("btnClosePayment"),
  btnPayCancel: document.getElementById("btnPayCancel"),
  btnPaySuccess: document.getElementById("btnPaySuccess"),
  payAmount: document.getElementById("payAmount"),
  payOrderId: document.getElementById("payOrderId"),
};

init();

function init() {
  els.year.textContent = String(new Date().getFullYear());

  initTheme();
  wireUI();
  renderCatalog();
  renderCart();
}

function wireUI() {
  els.btnCart.addEventListener("click", () => openDrawer());
  els.btnCloseCart.addEventListener("click", () => closeDrawer());
  els.backdrop.addEventListener("click", () => {
    closeDrawer();
    closeCheckout();
    closePayment();
  });

  document.addEventListener("keydown", (e) => {
    if (e.key !== "Escape") return;
    closeDrawer();
    closeCheckout();
    closePayment();
  });

  els.btnGoCatalog.addEventListener("click", () => closeDrawer());
  els.btnClearCart.addEventListener("click", () => {
    cart = {};
    persistCart();
    renderCart();
  });

  els.btnCheckout.addEventListener("click", () => {
    if (getCartCount() === 0) return;
    openCheckout();
  });

  els.btnCloseCheckout.addEventListener("click", () => closeCheckout());
  els.btnBackToCart.addEventListener("click", () => {
    closeCheckout();
    openDrawer();
  });

  els.checkoutForm.addEventListener("submit", (e) => onSubmitCheckout(e));
  els.delivery.addEventListener("change", () => updateTotalsEverywhere());

  els.search.addEventListener("input", () => renderCatalog());
  els.sort.addEventListener("change", () => renderCatalog());

  els.btnTheme.addEventListener("click", toggleTheme);

  els.btnQuickAdd.addEventListener("click", () => {
    const best = PRODUCTS.find((p) => p.featured) ?? PRODUCTS[0];
    addToCart(best.id, 1);
    openDrawer();
  });

  els.btnClosePayment.addEventListener("click", () => closePayment());
  els.btnPayCancel.addEventListener("click", () => {
    closePayment();
    openCheckout();
  });
  els.btnPaySuccess.addEventListener("click", () => {
    // Demo: success -> clear cart
    closePayment();
    closeCheckout();
    cart = {};
    persistCart();
    renderCart();
    toast("Оплата прошла (демо). Заказ оформлен.");
  });
}

function renderCatalog() {
  const query = (els.search.value ?? "").trim().toLowerCase();
  const sort = els.sort.value;

  let list = PRODUCTS.filter((p) => {
    if (!query) return true;
    return (
      p.name.toLowerCase().includes(query) ||
      p.desc.toLowerCase().includes(query) ||
      p.tag.toLowerCase().includes(query)
    );
  });

  list = sortProducts(list, sort);

  els.productGrid.innerHTML = "";

  if (list.length === 0) {
    els.productGrid.innerHTML = `
      <div class="empty" style="grid-column: 1 / -1;">
        <p class="empty__title">Ничего не найдено</p>
        <p class="empty__text">Попробуйте другой запрос или очистите поиск.</p>
        <button class="btn btn--ghost" type="button" id="btnClearSearch">Очистить поиск</button>
      </div>
    `;
    const btn = document.getElementById("btnClearSearch");
    btn?.addEventListener("click", () => {
      els.search.value = "";
      renderCatalog();
    });
    return;
  }

  const frag = document.createDocumentFragment();
  for (const p of list) {
    const node = document.createElement("article");
    node.className = "product";
    node.innerHTML = `
      <div class="product__top">
        <span class="pill">${escapeHtml(p.tag)}</span>
        <span class="pill">${formatMoney(p.price)}</span>
      </div>
      <h3 class="product__name">${escapeHtml(p.name)}</h3>
      <p class="product__desc">${escapeHtml(p.desc)}</p>
      <div class="product__bottom">
        <div class="price">${formatMoney(p.price)}</div>
        <div class="product__actions">
          <button class="btn btn--ghost btn--mini" type="button" data-action="details" data-id="${p.id}">Подробнее</button>
          <button class="btn btn--primary btn--mini" type="button" data-action="add" data-id="${p.id}">В корзину</button>
        </div>
      </div>
    `;

    node.addEventListener("click", (e) => {
      const btn = e.target instanceof HTMLElement ? e.target.closest("button[data-action]") : null;
      if (!btn) return;
      const id = btn.getAttribute("data-id");
      const action = btn.getAttribute("data-action");
      if (!id || !action) return;

      if (action === "add") {
        addToCart(id, 1);
        toast("Добавлено в корзину");
      }
      if (action === "details") {
        const p = PRODUCTS.find((x) => x.id === id);
        if (!p) return;
        toast(`${p.name} — ${formatMoney(p.price)}`);
      }
    });

    frag.appendChild(node);
  }
  els.productGrid.appendChild(frag);
}

function renderCart() {
  const items = getCartLineItems();
  const count = getCartCount();

  els.cartBadge.textContent = String(count);
  els.drawerSubtitle.textContent = pluralize(count, ["товар", "товара", "товаров"]);

  els.cartItems.innerHTML = "";
  els.cartEmpty.hidden = count !== 0;
  els.btnCheckout.disabled = count === 0;
  els.btnClearCart.disabled = count === 0;

  if (count === 0) {
    updateTotalsEverywhere();
    return;
  }

  const frag = document.createDocumentFragment();
  for (const li of items) {
    const node = document.createElement("div");
    node.className = "cart-item";
    node.innerHTML = `
      <div>
        <p class="cart-item__name">${escapeHtml(li.name)}</p>
        <p class="cart-item__meta">${formatMoney(li.price)} · ${escapeHtml(li.tag)}</p>
        <button class="link-danger" type="button" data-action="remove" data-id="${li.id}">Удалить</button>
      </div>
      <div style="display:grid; gap:8px; justify-items:end;">
        <div class="qty" aria-label="Количество">
          <button class="qty__btn" type="button" aria-label="Уменьшить" data-action="dec" data-id="${li.id}">−</button>
          <div class="qty__num" aria-label="Количество">${li.qty}</div>
          <button class="qty__btn" type="button" aria-label="Увеличить" data-action="inc" data-id="${li.id}">+</button>
        </div>
        <div style="font-weight:800;">${formatMoney(li.lineTotal)}</div>
      </div>
    `;

    node.addEventListener("click", (e) => {
      const btn = e.target instanceof HTMLElement ? e.target.closest("[data-action]") : null;
      if (!btn) return;
      const id = btn.getAttribute("data-id");
      const action = btn.getAttribute("data-action");
      if (!id || !action) return;

      if (action === "inc") addToCart(id, 1);
      if (action === "dec") addToCart(id, -1);
      if (action === "remove") removeFromCart(id);
    });

    frag.appendChild(node);
  }
  els.cartItems.appendChild(frag);

  updateTotalsEverywhere();
}

function updateTotalsEverywhere() {
  const subtotal = getCartSubtotal();
  const shipping = getShippingCost(subtotal);
  const total = subtotal + shipping;

  els.subtotal.textContent = formatMoney(subtotal);
  els.shipping.textContent = formatMoney(shipping);
  els.total.textContent = formatMoney(total);
  els.checkoutTotal.textContent = formatMoney(total);
}

function openDrawer() {
  els.backdrop.hidden = false;
  els.drawer.hidden = false;
  lockScroll(true);
}

function closeDrawer() {
  if (els.drawer.hidden) return;
  els.drawer.hidden = true;
  // keep backdrop if another modal is open
  if (els.checkoutModal.hidden && els.paymentModal.hidden) {
    els.backdrop.hidden = true;
    lockScroll(false);
  }
}

function openCheckout() {
  closeDrawer();
  els.backdrop.hidden = false;
  els.checkoutModal.hidden = false;
  lockScroll(true);
  updateTotalsEverywhere();
}

function closeCheckout() {
  if (els.checkoutModal.hidden) return;
  els.checkoutModal.hidden = true;
  if (els.drawer.hidden && els.paymentModal.hidden) {
    els.backdrop.hidden = true;
    lockScroll(false);
  }
}

function openPayment({ orderId, amount }) {
  closeCheckout();
  els.backdrop.hidden = false;
  els.paymentModal.hidden = false;
  lockScroll(true);
  els.payOrderId.textContent = orderId;
  els.payAmount.textContent = formatMoney(amount);
}

function closePayment() {
  if (els.paymentModal.hidden) return;
  els.paymentModal.hidden = true;
  if (els.drawer.hidden && els.checkoutModal.hidden) {
    els.backdrop.hidden = true;
    lockScroll(false);
  }
}

function onSubmitCheckout(e) {
  e.preventDefault();

  if (getCartCount() === 0) {
    toast("Корзина пустая");
    closeCheckout();
    return;
  }

  const form = els.checkoutForm;
  if (!form.checkValidity()) {
    // basic UX: trigger native validation UI
    form.reportValidity();
    return;
  }

  updateTotalsEverywhere();

  const subtotal = getCartSubtotal();
  const shipping = getShippingCost(subtotal);
  const total = subtotal + shipping;

  // Here we would POST to PHP:
  // - create order
  // - create payment session
  // - redirect to provider
  const orderId = `SP-${Date.now().toString(36).toUpperCase()}`;

  if (els.payment.value === "online") {
    openPayment({ orderId, amount: total });
    return;
  }

  // Non-online demo: consider it placed
  closeCheckout();
  cart = {};
  persistCart();
  renderCart();
  toast(`Заказ ${orderId} оформлен (демо)`);
}

function addToCart(id, delta) {
  const p = PRODUCTS.find((x) => x.id === id);
  if (!p) return;

  const next = (cart[id] ?? 0) + delta;
  if (next <= 0) delete cart[id];
  else cart[id] = next;

  persistCart();
  renderCart();
}

function removeFromCart(id) {
  if (!cart[id]) return;
  delete cart[id];
  persistCart();
  renderCart();
}

function getCartCount() {
  return Object.values(cart).reduce((sum, n) => sum + n, 0);
}

function getCartSubtotal() {
  let sum = 0;
  for (const [id, qty] of Object.entries(cart)) {
    const p = PRODUCTS.find((x) => x.id === id);
    if (!p) continue;
    sum += p.price * qty;
  }
  return sum;
}

function getShippingCost(subtotal) {
  const delivery = els.delivery?.value ?? "courier";
  if (subtotal <= 0) return 0;
  if (delivery === "pickup") return 0;
  return 399;
}

function getCartLineItems() {
  /** @type {{id:string,name:string,tag:string,price:number,qty:number,lineTotal:number}[]} */
  const items = [];
  for (const [id, qty] of Object.entries(cart)) {
    const p = PRODUCTS.find((x) => x.id === id);
    if (!p) continue;
    items.push({
      id,
      name: p.name,
      tag: p.tag,
      price: p.price,
      qty,
      lineTotal: p.price * qty,
    });
  }
  items.sort((a, b) => a.name.localeCompare(b.name, "ru"));
  return items;
}

function persistCart() {
  try {
    localStorage.setItem(STORAGE_KEYS.cart, JSON.stringify(cart));
  } catch {
    // ignore
  }
}

function loadCart() {
  try {
    const raw = localStorage.getItem(STORAGE_KEYS.cart);
    if (!raw) return {};
    const parsed = JSON.parse(raw);
    if (!parsed || typeof parsed !== "object") return {};
    /** @type {Record<string, number>} */
    const safe = {};
    for (const [k, v] of Object.entries(parsed)) {
      if (typeof v !== "number" || !Number.isFinite(v) || v <= 0) continue;
      safe[k] = Math.floor(v);
    }
    return safe;
  } catch {
    return {};
  }
}

function sortProducts(list, sort) {
  const next = [...list];
  if (sort === "price-asc") next.sort((a, b) => a.price - b.price);
  if (sort === "price-desc") next.sort((a, b) => b.price - a.price);
  if (sort === "name-asc") next.sort((a, b) => a.name.localeCompare(b.name, "ru"));
  if (sort === "featured") {
    next.sort((a, b) => Number(Boolean(b.featured)) - Number(Boolean(a.featured)));
  }
  return next;
}

function formatMoney(n) {
  return new Intl.NumberFormat("ru-RU", {
    style: "currency",
    currency: "RUB",
    maximumFractionDigits: 0,
  }).format(n);
}

function pluralize(n, forms) {
  // forms: ["товар","товара","товаров"]
  const abs = Math.abs(n) % 100;
  const n1 = abs % 10;
  if (abs > 10 && abs < 20) return `${n} ${forms[2]}`;
  if (n1 > 1 && n1 < 5) return `${n} ${forms[1]}`;
  if (n1 === 1) return `${n} ${forms[0]}`;
  return `${n} ${forms[2]}`;
}

function escapeHtml(s) {
  return String(s)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function lockScroll(locked) {
  document.documentElement.style.overflow = locked ? "hidden" : "";
}

function initTheme() {
  const saved = getSavedTheme();
  if (saved) {
    document.documentElement.dataset.theme = saved;
    return;
  }
  // prefer OS
  const prefersDark = window.matchMedia?.("(prefers-color-scheme: dark)")?.matches;
  document.documentElement.dataset.theme = prefersDark ? "dark" : "light";
}

function toggleTheme() {
  const cur = document.documentElement.dataset.theme === "dark" ? "dark" : "light";
  const next = cur === "dark" ? "light" : "dark";
  document.documentElement.dataset.theme = next;
  try {
    localStorage.setItem(STORAGE_KEYS.theme, next);
  } catch {
    // ignore
  }
}

function getSavedTheme() {
  try {
    const t = localStorage.getItem(STORAGE_KEYS.theme);
    if (t === "dark" || t === "light") return t;
    return null;
  } catch {
    return null;
  }
}

let toastTimer = 0;
function toast(message) {
  const id = "toast";
  let el = document.getElementById(id);
  if (!el) {
    el = document.createElement("div");
    el.id = id;
    el.setAttribute("role", "status");
    el.style.position = "fixed";
    el.style.left = "50%";
    el.style.bottom = "22px";
    el.style.transform = "translateX(-50%)";
    el.style.padding = "10px 12px";
    el.style.borderRadius = "999px";
    el.style.border = "1px solid var(--border)";
    el.style.background = "color-mix(in oklab, var(--glass-2) 92%, transparent)";
    el.style.boxShadow = "var(--shadow)";
    el.style.backdropFilter = "blur(14px)";
    el.style.webkitBackdropFilter = "blur(14px)";
    el.style.fontWeight = "650";
    el.style.fontSize = "13px";
    el.style.zIndex = "999";
    document.body.appendChild(el);
  }
  el.textContent = message;
  el.style.opacity = "1";
  window.clearTimeout(toastTimer);
  toastTimer = window.setTimeout(() => {
    if (!el) return;
    el.style.opacity = "0";
  }, 1600);
}

