<?php
require_once __DIR__ . '/vendor/autoload.php';

//$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
//$dotenv->load();

//const API_PATH = __DIR__ . '/../api';

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

echo '<pre>';
print_r($router->getRoutes());
echo '</pre>';

echo '<br>';
echo 'http host ' . $_SERVER['HTTP_HOST'];
echo '<br>';
echo 'SCRIPT_FILENAME ' . $_SERVER['SCRIPT_FILENAME'];
echo '<br>';
echo 'DOCUMENT_ROOT' . $_SERVER['DOCUMENT_ROOT'];
echo '<br>';
echo 'DOCUMENT_URI' . $_SERVER['DOCUMENT_URI'];
echo '<br>';
echo 'HTTP_HOST' . $_SERVER['HTTP_HOST'];
echo '<br>';
var_dump($_SERVER);