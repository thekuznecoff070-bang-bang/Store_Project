<?php
declare(strict_types=1);

class Order  //<--создаётся класс ордера, который будет работать с таблицей orders в БД
{
    public static function create(array $data): int //<--создаётся статический метод create, который принимает массив данных и возвращает ID созданного заказа
    {
        $db = Database::getConnection(); //<--получаем соединение с базой данных через класс Database

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
}