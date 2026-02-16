-- Store_Project Database Schema
-- Created: 2026-02-13
-- Updated: 2026-02-16

USE store_db;

-- Products table (основная таблица товаров)
CREATE TABLE IF NOT EXISTS products
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255)   NOT NULL,
    description TEXT      DEFAULT NULL,
    price       DECIMAL(10, 2) NOT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- Orders table
CREATE TABLE IF NOT EXISTS orders
(
    id             INT AUTO_INCREMENT PRIMARY KEY,
    customer_name  VARCHAR(255)   NOT NULL,
    customer_phone VARCHAR(50)    NOT NULL,
    total_price    DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at     TIMESTAMP               DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- Order items table
CREATE TABLE IF NOT EXISTS order_items
(
    id         INT AUTO_INCREMENT PRIMARY KEY,
    order_id   INT            NOT NULL,
    product_id INT            NOT NULL,
    quantity   INT            NOT NULL DEFAULT 1,
    price      DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- Тестовые товары с описаниями
INSERT INTO products (name, description, price)
VALUES ('AirBuds 2', 'Лёгкие наушники с чистым звуком и низкой задержкой.', 8990.00),
       ('AirBuds Pro', 'Шумоподавление, режим прозрачности и плотная посадка.', 15990.00),
       ('Watch Lite', 'Сон, активность, уведомления. Автономность до 7 дней.', 12990.00),
       ('Dock MagSnap', 'Минималистичная док-станция для телефона и наушников.', 6990.00),
       ('Keyboard Slim', 'Тихий ход, алюминиевый корпус, Bluetooth + USB-C.', 9990.00),
       ('Display 27', 'Тонкие рамки, точные цвета, комфорт для глаз.', 44990.00)
ON DUPLICATE KEY UPDATE name=name;