<?php
require 'constants.php';
require __DIR__.'\..\vendor\autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ENV_PATH);
$dotenv->load();

$dbhost = $_ENV['DB_HOST'];
$dbport = $_ENV['DB_PORT'];
$dbuser = $_ENV['DB_USER'];
$dbpass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

try {
    $stmt = <<<EOS
    CREATE DATABASE IF NOT EXISTS `$dbname`;

    USE `$dbname`;

    CREATE TABLE IF NOT EXISTS endereco (
        cep             VARCHAR(9)      NOT NULL,
        logradouro      TEXT            NOT NULL,
        complemento     TEXT            NOT NULL,
        bairro          TEXT            NOT NULL,
        localidade      TEXT            NOT NULL,
        uf              VARCHAR(2)      NOT NULL,
        PRIMARY KEY (cep)
    );
    EOS;
    echo 'DATABASE INITIALIZER'.PHP_EOL.PHP_EOL;
    $pdo = new PDO("mysql:dbhost=$dbhost;dbport=$dbport", $dbuser, $dbpass);
    $pdo->exec($stmt) or die(print_r($pdo->errorInfo(), true));
    echo 'Done.';
} catch (PDOException $e) {
    exit($e->getMessage());
}