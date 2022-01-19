<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const API_PATH = __DIR__ . '/../api';

use App\Controllers\CategoriesController;

$router = new \App\Router();
$router
    ->register('/api/categories', [CategoriesController::class, 'read'], 'get')
    ->register('/api', [CategoriesController::class, 'errorController'], 'get')
    ->register('/api/all', [\App\Controllers\TestsController::class, 'index'], 'get');
try {
    $router->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
} catch (\App\Exceptions\RouteNotFoundException $e) {
    echo $e->getMessage();
}