<?php

/**
 * @property PDO $conn
 * @property string $tableName
 * @property int $id
 * @property string $name
 * @property double $price
 * @property int $dateAndTime
 * @property int $created
 */
class Product {

    private $conn;
    private $tableName = "products";

    public $id;
    public $name;
    public $price;
    public $dateAndTime;
    public $created;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = 'SELECT * FROM `' . $this->tableName . '` ORDER BY date_and_time';
        return $this->conn->query($query);
    }

    public function create(){
        $query = 'INSERT INTO ' . $this->tableName . ' (name, price, date_and_time, created) VALUES (:name, :price, :dateAndTime, :created)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":dateAndTime", $this->dateAndTime);
        $stmt->bindParam(":created", $this->created);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
