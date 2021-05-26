<?php
namespace BuscadorCEP\Controllers;

class Controller
{
    private $method;
    private $gateway;

    protected function __construct($method, $gateway)
    {
        $this->method = $method;
        $this->gateway = $gateway;
    }
    public function getMethod()
    {
        return $this->method;
    }
    public function getGateway()
    {
        return $this->gateway;
    }
}
