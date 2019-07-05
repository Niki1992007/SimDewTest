<?php

header("Access-Control-Allow-Origin: *"); // файл может быть прочитан кем угодно
header("Access-Control-Allow-Headers: access"); // Контроль доступа - разрешить заголовки
header("Access-Control-Allow-Methods: GET"); // для CORS, ограничить методы при отправке заголовка
header("Access-Control-Allow-Credentials: true"); // Контроль доступа - разрешить учётные данные
header('Content-Type: application/json'); // данные в формате JSON


include_once '../config/database.php';
include_once '../objects/product.php';


$database = new Database();
$db = $database->getConnection();


$product = new Product($db);

// Проверить поле на существование и разрешить его читать из GET
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// метод достаёт информации об определённом продукте
$product->readOne();

// Если в продукте поле имя не null
if($product->name!=null){
    // создадим массив -> передадим туда значения полей
    $product_arr = array(
        "id" =>  $product->id,
        "name" => $product->name,
        "description" => $product->description,
        "price" => $product->price,
        "category_id" => $product->category_id,
        "category_name" => $product->category_name

    );

    // Если всё нормально
    http_response_code(200);

    // преобразовать
    echo json_encode($product_arr, JSON_PRETTY_PRINT);
}

// иначе
else{
    // 404 Not found
    http_response_code(404);

    // сообщим
    echo json_encode(array("message" => "Данный товар не существует"),JSON_UNESCAPED_UNICODE);
}
?>