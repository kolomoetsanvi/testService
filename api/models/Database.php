<?php

//include_once '../config/config.php';
/**
 * @property string $host
 * @property string $dbName
 * @property string $userName
 * @property string $password
 * @property PDO $conn
 */
class Database {
    private $host;
    private $dbName;
    private $userName;
    private $password;
    private $conn;

    /**
     * Database constructor.
     */
    function __construct($config)
    {
        $this->host = $config["host"];
        $this->dbName = $config["dbName"];
        $this->userName = $config["userName"];
        $this->password = $config["password"];
    }

    /**
     * @return PDO|null
     */
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->password);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}