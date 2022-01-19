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
$test = new Test($db);

if (isset($_GET['limit'])) {
    $test->limit = $_GET['limit'];
}

if (isset($_GET['offset'])) {
    $test->offset = $_GET['offset'];
}

// запрашиваем товары
$stmt = $test->getAllTests();
$num = $stmt->rowCount();

// проверка, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $products_arr=array();
    $products_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее, чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        // извлекаем строку
        extract($row);

        $product_item=array(
            "price_id" => $price_id,
            "article" => $article,
            "name" => $name,
            "shortinfo" => $shortinfo,
            "longinfo" => $longinfo,
            "details" => $details,
            "indications" => $indications,
            "preparation" => $preparation,
            "methods" => $methods,
            "howto" => $howto,
            "results" => $results,
            "price" => $price,
            "related_tests" => $related_tests
        );

        array_push($products_arr["records"], $product_item);
    }

    // устанавливаем код ответа - 200 OK
    http_response_code(200);

    // выводим данные о товаре в формате JSON
    echo json_encode($products_arr);
}

else {

    // установим код ответа - 404 Не найдено
    http_response_code(404);

    // сообщаем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}

