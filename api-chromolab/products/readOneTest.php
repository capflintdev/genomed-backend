<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once '../config/database.php';
include_once '../objects/Tests.php';
// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$one = new Test($db);

$one->article = $_GET['article'] ?? die();
$one->readOne();

if ($one->name!=null) {

    // создание массива
    $product_arr = array(
        "price_id" =>  $one->price_id,
        "article" =>  $one->article,
        "category_path" =>  $one->category_path,
        "name" => $one->name,
        "shortinfo" => $one->shortinfo,
        "longinfo" => $one->longinfo,
        "details" => $one->details,
        "indications" => $one->indications,
        "preparation" => $one->preparation,
        "methods" => $one->methods,
        "howto" => $one->howto,
        "results" => $one->results,
        "price" => $one->price,
        "related_tests" => $one->related_tests
    );

    // код ответа - 200 OK
    http_response_code(200);

    // вывод в формате json
    echo json_encode($product_arr);
}

else {
    // код ответа - 404 Не найдено
    http_response_code(404);

    // сообщим пользователю, что товар не существует
    echo json_encode(array("message" => "Записи не существует."), JSON_UNESCAPED_UNICODE);
}