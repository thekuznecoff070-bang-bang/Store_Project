# Store_Project — Инструкция по запуску

## ✅ Проект настроен и запущен!

### Доступ к приложению

- 🌐 **Веб-сайт**: http://localhost:8081
- 📦 **Каталог товаров**: http://localhost:8081/products
- 🗄️ **MySQL (phpStorm)**: 127.0.0.1:3307, user: root, password: root, db: store_db

### Запущенные контейнеры

```
store-project-nginx     → порт 8081 (веб-сервер)
store-project-php-fpm   → порт 9000 (PHP)
store-project-db        → порт 3307 (MySQL)
```

### Команды управления

```bash
# Из корня Store_Project используй docker.sh:

./docker.sh up       # Запустить контейнеры
./docker.sh down     # Остановить
./docker.sh restart  # Перезапустить
./docker.sh build    # Пересобрать
./docker.sh logs     # Посмотреть логи (Ctrl+C для выхода)
./docker.sh ps       # Статус контейнеров

# Или из папки docker/:
cd docker
docker-compose up -d
docker-compose down
docker-compose logs -f
docker-compose ps
```

### Подключение к MySQL из phpStorm

1. Data Sources → MySQL
2. Host: `127.0.0.1`
3. Port: `3307`
4. Database: `store_db`
5. User: `root`
6. Password: `root`

### Таблицы БД

**products** — каталог товаров:
- Товар 1 (1000 ₽)
- Товар 2 (2500 ₽)
- Товар 3 (3999 ₽)

**orders** — заказы клиентов:
- id, customer_name, customer_phone, total_price, created_at

**order_items** — товары в заказах:
- id, order_id, product_id, quantity, price
- Внешние ключи к orders и products

### Структура проекта

```
Store_Project/
├── public/           → document root (index.php)
├── app/
│   ├── Controllers/  → контроллеры
│   ├── Models/       → модели
│   ├── Core/         → ядро (Router, Database)
│   └── Views/        → представления
├── config/           → конфигурация (config.php)
└── docker/           → Docker конфигурация
```

---

**Готово! Проект работает на http://localhost:8081** 🎉

