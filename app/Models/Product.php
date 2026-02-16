<?php
declare(strict_types=1);

require_once __DIR__ . '/../Core/Database.php';

class Product
{
    /**
     * Получить ВСЕ товары
     */
    public static function all(): array
    {
        $pdo = Database::connect();
        $stmt = $pdo->query('SELECT id, name, description, price FROM products');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Найти товар по ID
     */
    public static function find(int $id): ?array
    {
        $pdo = Database::connect();
        $stmt = $pdo->prepare('SELECT id, name, description, price FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        return $product ?: null;
    }

    /**
     * Поиск + сортировка товаров
     *
     * @param string $search — поисковый запрос (ищем в name и description)
     * @param string $sort   — способ сортировки
     * @return array
     */
    public static function search(string $search = '', string $sort = 'default'): array
    {
        $pdo = Database::connect();

        // Начинаем строить SQL-запрос
        $sql = 'SELECT id, name, description, price FROM products';
        $params = [];

        // Если есть поисковый запрос — добавляем WHERE
        if ($search !== '') {
            $sql .= ' WHERE name LIKE :search OR description LIKE :search';
            $params['search'] = '%' . $search . '%';
        }

        // Добавляем сортировку
        switch ($sort) {
            case 'price-asc':
                $sql .= ' ORDER BY price ASC';
                break;
            case 'price-desc':
                $sql .= ' ORDER BY price DESC';
                break;
            case 'name-asc':
                $sql .= ' ORDER BY name ASC';
                break;
            default:
                $sql .= ' ORDER BY id ASC';
                break;
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}