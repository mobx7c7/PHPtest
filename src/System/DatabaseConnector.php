<?php
namespace BuscadorCEP\System;

use BuscadorCEP\Helpers\ResponseHelper;

class DatabaseConnector
{
    private $pdo = null;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $name = $_ENV['DB_NAME'];

        try {
            $this->pdo = new \PDO("mysql:host=$host;port=$port;dbname=$name", $user, $pass);
        } catch (\PDOException $e) {
            ResponseHelper::makeError(500, 'Não foi possível abrir conexão com a base de dados')->send();
            exit();
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
