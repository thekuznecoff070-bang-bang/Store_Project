<?php
declare(strict_types=1);

class HomeController
{
    public function index(): void
    {
        $title = 'Главная страница';
        $content = __DIR__ . '/../Views/home.php';
        require __DIR__ . '/../Views/layout.php';
    }
}
