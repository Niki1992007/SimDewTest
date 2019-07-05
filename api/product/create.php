<?php


// required headers
header("Access-Control-Allow-Origin: *"); // файл может быть прочитан кем угодно
header("Content-Type: application/json; charset=UTF-8"); // данные в формате JSON
header("Access-Control-Allow-Methods: GET, POST"); // для CORS, ограничить методы при отправке заголовка
header("Access-Control-Max-Age: 3600"); // время на которое кешируется предзапрос
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// подключиться к БД
include_once '../config/database.php';

// подключить класс с продуктом
include_once '../objects/product.php';

// Инициализировать подключение к БД
$database = new Database();
$db = $database->getConnection();

// Создать объект класса продкут
$product = new Product($db);


// Получить данные из потока (чё за потоки, блин...) и преобразовать
$data = json_decode(file_get_contents("php://input"));

// Проверить данные на существование
if (
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)
) {

    // установить значения свойств объекта продукт
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');

    // создать продукт при помощи описанного метода
    if ($product->create()) {

        // установить код ответа - 201 создано
        http_response_code(201);

        // вывести пользователю
        echo json_encode(array("message" => "Продукт успешно создан"), JSON_UNESCAPED_UNICODE);
    } // если не удается создать продукт, сообщить пользователю
    else {

        // установить код овтета - 503 сервис недоступен
        http_response_code(503);

        // вывести пользователю
        echo json_encode(array("message" => "Не удалось создать продукт"),JSON_UNESCAPED_UNICODE);
    }
} // если данные пользователя неполны
else {

    // код ответа - 400 неверный запрос
    http_response_code(400);

    // вывести пользователю
    echo json_encode(array("message" => "Невозможно создать продукт. Данные неполные"), JSON_UNESCAPED_UNICODE);
}
?>