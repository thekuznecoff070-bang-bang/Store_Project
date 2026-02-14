<?php

declare(strict_types=1);

session_start();

require_once __DIR__ . '/../app/Core/Router.php';

// 1. Инициализация роутера
$router = new Router();
$router->run();

