<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\CompanyClient;
use App\Controller\CompanyController;
use App\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$client = new CompanyClient($_ENV['CHECKO_API_KEY']);
$controller = new CompanyController($client);

$router = new Router();
$router->add('GET', '/api/company', function() use ($controller) {
    $controller->getCompanyInfo();
});
$router->add('GET', '/api/contracts', function() use ($controller) {
    $controller->getCompanyContracts();
});
$router->add('GET', '/api/arbitrations', function() use ($controller) {
    $controller->getCompanyArbitrations();
});

try {
    $router->check(
        $_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
    );
} catch (\Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
}