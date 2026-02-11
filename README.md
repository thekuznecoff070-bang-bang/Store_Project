## Store_Project (vanilla)

Демо-фронтенд магазина в стиле apple.com без фреймворков: **HTML + CSS + JS**.

### Что уже есть
- Каталог товаров (рендер из JS-данных)
- Корзина (drawer справа), количество, удаление, очистка
- Оформление заказа (форма + валидация)
- Заглушка "Онлайн-оплата" (имитация редиректа/провайдера)
- Сохранение корзины в `localStorage`

### Как запустить через Docker

Проект интегрирован в Docker Compose окружение. 

**Запустить контейнеры:**
```bash
cd /home/project
docker-compose up -d --build
```

**Открыть в браузере:**
```
http://localhost:8080/store-project/
```

### Как запустить локально

Откройте файл `index.php` в браузере (двойной клик) ИЛИ запустите локальный сервер:

**PHP:**
```bash
cd /path/to/Store_Project
php -S localhost:8000
```

**Node.js (http-server):**
```bash
npx http-server ./ -p 8000
```

**Python:**
```bash
python -m http.server 8000
```

Затем откройте: `http://localhost:8000/`

### Структура проекта

```
Store_Project/
├── index.php          # Основной HTML/PHP файл
├── css/
│   └── styles.css    # Стили (Apple-style)
├── js/
│   └── app.js        # Логика магазина (каталог, корзина, форма, оплата)
├── README.md         # Этот файл
└── .htaccess         # Для Apache (если нужен)
```

### Docker конфигурация

Store_Project настроен в Nginx как отдельная локация:
- **URL:** `http://localhost:8080/store-project/`
- **Контейнер Nginx:** переправляет запросы на `/Store_Project/` из проекта
- **PHP обработка:** работает через php-fpm контейнер

Дополнительная информация о Docker: см. `/DOCKER_SETUP.md` в корне проекта.

### Решение проблем

**CSS/JS не загружаются:**
- Проверьте в DevTools > Network вкладке реальные URLs
- Убедитесь, что файлы существуют в `/Store_Project/css/` и `/Store_Project/js/`

**Из Docker не видно изменения файлов:**
- Это может быть кэш браузера. Используйте Ctrl+Shift+Delete или откройте DevTools > Settings > Disable cache
- Или выполните `docker-compose restart nginx`

