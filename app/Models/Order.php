<?php
declare(strict_types=1);

class Order  //<--создаётся класс ордера, который будет работать с таблицей orders в БД
{
    public static function create(array $data): int //<--создаётся статический метод create, который принимает массив данных и возвращает ID созданного заказа
    {
        require_once __DIR__ . '/../Core/Database.php';
        $db = Database::connect(); //<--получаем соединение с базой данных через класс Database

        $sql = "
            INSERT INTO orders (user_name, user_phone, total_price, created_at)
            VALUES (:user_name, :user_phone, :total_price, NOW())
        "; //<--SQL-запрос для вставки нового заказа в таблицу orders. Используются именованные параметры для безопасности и удобства.
        $stmt = $db->prepare($sql); //<--подготавливаем SQL-запрос к выполнению
        $stmt->execute([ //<--выполняем подготовленный запрос, передавая данные из массива $data в виде ассоциативного массива
            ':user_name' => $data['user_name'],
            ':user_phone' => $data['user_phone'],
            ':total_price' => $data['total_price'],
        ]);

        return (int)$db->lastInsertId(); //<--возвращаем ID последнего вставленного заказа, приводя его к целому числу
    }

    public static function findById(int $id): ?array
    {
        require_once __DIR__ . '/../Core/Database.php';
        $db = Database::connect();

        $stmt = $db->prepare('SELECT * FROM orders WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        return $order ?: null; // Возвращаем данные заказа или null, если заказ не найден
    }
}