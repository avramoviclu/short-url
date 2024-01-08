<?php

declare(strict_types=1);

namespace ShortUrl\Database;

use PDO;

class MySqlConnection
{  
    private static $instance;

    private string $host;
   
    private string $name;
   
    private string $username;

    private string $password;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];

        $this->name = $_ENV['DB_NAME'];

        $this->username = $_ENV['DB_USERNAME'];

        $this->password = $_ENV['DB_PASSWORD'];
    }

    public static function getInstance(): self
    {
        if (! self::$instance) {

            self::$instance = new self();

        }

        return self::$instance;
    }

    public function connect(): PDO
    {
        $pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->name,
            $this->username, $this->password);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        return $pdo;
    }
}
