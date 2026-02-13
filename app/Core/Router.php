<?php
declare(strict_types=1);

class Router
{
    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Удалить префикс /store-project если он есть
        if (strpos($uri, '/store-project/') === 0) {
            $uri = substr($uri, strlen('/store-project'));
        }

        $uri = trim($uri, '/');

        switch ($uri) {
            case '':
            case 'home':
                require_once __DIR__. '/../Controllers/HomeController.php';
                $controller = new HomeController();
                $controller->index();
                break;

            case 'products':
                require_once __DIR__. '/../Controllers/ProductController.php';
                $controller = new ProductController();
                $controller->index();
                break;

            default:
                http_response_code(404);
                echo '404 Not Found';
                break;
        }
    }
}