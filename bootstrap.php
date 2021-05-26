<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;
use BuscadorCEP\System\DatabaseConnector;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbConnection = (new DatabaseConnector())->getConnection();
