<?php
$config = json_decode(file_get_contents('../config/config.json'), true);
define('DB_HOST', $config['DB_HOST']);
define('DB_USER', $config['DB_USER']);
define('DB_PASS', $config['DB_PASS']);
define('DB_NAME', $config['DB_NAME']);

class DefaultConnection
{
    private static ?DefaultConnection $instance = null;

    public static function getDefaultConnection() : mysqli
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }

        return self::$instance->conn;
    }

    private mysqli $conn;
    private function __construct() 
    {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if($this->conn->connect_error) {
            die('Connection Failed' . $this->conn->connect_error);
        }
    }
}