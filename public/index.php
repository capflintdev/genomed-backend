<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const API_PATH = __DIR__ . '/../api';

use App\Controllers\CategoriesController;

$router = new \App\Router();
$router
    ->register('/api/categories', [CategoriesController::class, 'index'], 'get')
    ->register('/api/all', [\App\Controllers\TestsController::class, 'index'], 'get')
//    ->register('/api/tests', [\App\Controllers\TestsController::class, 'tests'], 'get')
    ->resolve($_SERVER['REQUEST_URI'], strtolower($_SERVER['REQUEST_METHOD']));
//    ->register('/api/categories', [], 'get')
//    ->register('/api/test', [], 'get');

//(new \App\App(
//    $router,
//    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']]
//))->run();

//$config = new \App\Config();
//
//$connection = (new \App\DB((new \App\Config())->extract()))->getPdo();
//echo '<pre>';
//var_dump(new \App\App($router, ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']], new \App\Config($_ENV)));
//echo '</pre>';

//use PDO;

//$pdo = new PDO('mysql:host=db;dbname=genomed', 'root', 'root');
//$query = "select * from chrom_tests";
//$stmt = $connection->query($query);
//print_r($stmt->fetchAll());
//var_dump($pdo);
//var_dump($connection->getPdo());

//$category = new CategoriesController();
//
//print_r($category->index());