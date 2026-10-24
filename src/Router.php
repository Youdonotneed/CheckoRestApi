<?php

namespace App;

use App\Service\CompanyClient;
use App\Controller\CompanyController;

class Router {
    private array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    public function add (string $method, string $path, callable $handler) {
        $routeKey = $method . ' ' . $path;
        $this->routes[$routeKey] = $handler;
    }

    public function check(string $method, string $uri): void {
        $routeKey = $method . ' ' . $uri;

        if (isset($this->routes[$routeKey])) {
            $handler = $this->routes[$routeKey];
            $handler();
        } else {
            throw new \Exception("Маршрут не найден", 404);
        }
    }
}