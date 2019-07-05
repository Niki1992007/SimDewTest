<?php

class Database
{

    // укажите свои собственные учетные данные базы данных
    private $host = "localhost";
    private $db_name = "api_db";
    private $username = "root";
    private $password = "";
    public $conn;

    //получить соединение с базой данных
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Ошибка соединения с базой данных: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>