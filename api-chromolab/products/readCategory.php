<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение базы данных и файл, содержащий объекты
include_once '../config/database.php';
include_once '../objects/Categories.php';
// получаем соединение с базой данных
$database = new Database();
$db = $database->getConnection();

// инициализируем объект
$category = new Category($db);

$category->category_path = $_GET['path'] ?? die();
$category->readOneCategory();

if ($category->category!=null) {

    // создание массива
    $product_arr = array(
        "category" =>  $category->category,
        "category_path" =>  $category->category_path,
        "description" => $category->description,
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
