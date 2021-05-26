<?php
namespace BuscadorCEP\Gateways;

class Gateway
{
    private $db = null;
    
    protected function __construct($db)
    {
        $this->db = $db;
    }
    protected function getConnection()
    {
        return $this->db;
    }
}
