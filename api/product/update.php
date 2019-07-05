<?php
// заголовки запроса
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключение базы и класса
include_once '../config/database.php';
include_once '../objects/product.php';

// получить соединение с базой
$database = new Database();
$db = $database->getConnection();

// инициализировать экземпляр класса
$product = new Product($db);

// не понимаю до конца, откуда всё-таки приходит строка, которая декодируется из JSON
$data = json_decode(file_get_contents("php://input"));

// устанавливаем свойство идентификатора
$product->id = $data->id;

// остальеные свойства
$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;

// обновим продукт по описанному в классе product.php методу update();
if($product->update()){

    // сработало - 200 ok
    http_response_code(200);

    // сообщить
    echo json_encode(array("message" => "Товар успешно обновлен"), JSON_UNESCAPED_UNICODE);
}

// если нет, ведем код ответа и сообщение об ошибке
else{

    http_response_code(503);

    echo json_encode(array("message" => "Невозможно обновить продукт"), JSON_UNESCAPED_UNICODE);
}
?>