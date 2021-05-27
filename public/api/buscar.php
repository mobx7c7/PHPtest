<?php
require $_SERVER['DOCUMENT_ROOT'].'/../bootstrap.php';

use BuscadorCEP\Controllers\EnderecoController;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

function handleEndereco()
{
    $method = $_SERVER["REQUEST_METHOD"];
    $cep = $_GET['cep'];
    global $dbConnection;
    $controller = new EnderecoController($dbConnection, $method, $cep);
    $controller->process();
}

if (isset($_GET['cep'])) {
    handleEndereco();
} else {
    http_response_code(404);
    exit();
}
