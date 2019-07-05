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

    // Метод прочитать продукт
    function read()
    {

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

    // Метод создать продукт
    function create()
    {

        // запрос на вставку записи
        $query = "INSERT INTO
                " . $this->table_name . " 
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";

        //  Подготавливает запрос к выполнению и возвращает связанный с этим запросом объект
        $stmt = $this->conn->prepare($query);

        // убрать лишнее
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        // связать значения
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);

        // Запускает подготовленный запрос на выполнение
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    // Вывести один продукт
    function readOne() {

        // запрос на чтение одной записи
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            WHERE
                p.id = ?
            LIMIT
                0,1";


        // подготовить оператор запроса
        $stmt = $this->conn->prepare($query);

        // Привязывает параметр запроса к переменной
        $stmt->bindParam(1, $this->id); // https://www.php.net/manual/ru/pdostatement.bindparam.php

        // выполнить запрос
        $stmt->execute();

        //получить извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // https://www.php.net/manual/ru/pdostatement.fetch.php

        // установить занчения в свойства объекта
        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }

    // Обновить продукт
    function update(){

        // запрос на обновление
        $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                price = :price,
                description = :description,
                category_id = :category_id
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
            return true;
        }

        return false;
    }
}
