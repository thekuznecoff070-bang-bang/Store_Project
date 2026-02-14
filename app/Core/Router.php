<?php

declare(strict_types=1);

class Router
{
    public function run(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = trim($uri, '/');


        switch ($uri) {
            case '':
                require_once __DIR__ . '/../Controllers/HomeController.php';
                (new HomeController())->index();
                break;

            case 'products':
                require_once __DIR__ . '/../Controllers/ProductController.php';
                (new ProductController())->index();
                break;

            case 'cart':
                require_once __DIR__ . '/../Controllers/CartController.php';
                (new CartController())->index();
                break;

            case 'cart/add':
                require_once __DIR__ . '/../Controllers/CartController.php';
                (new CartController())->add();
                break;

            case 'cart/remove':
                require_once __DIR__ . '/../Controllers/CartController.php';
                (new CartController())->remove();
                break;

            case 'checkout':
                require_once __DIR__ . '/../Controllers/CheckoutController.php';

                $controller = new CheckoutController();

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->submit();
                } else {
                    $controller->form();
                }

                break;

            default:
                http_response_code(404);
                echo '404 Not Found';
        }
    }
}
