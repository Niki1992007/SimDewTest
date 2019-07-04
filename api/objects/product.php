<?php

class Product
{

    //подключение к базе данных и имя таблицы
    private $conn;
    private $table_name = "products";

    // свойства объекта
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // метод конструкт для соединения с БД
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Прочитать продукт
    function read(){

        // весь запрос
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";

        // подготовить запрос
        $stmt = $this->conn->prepare($query);

        // выполнить
        $stmt->execute();

        return $stmt;
    }
}
