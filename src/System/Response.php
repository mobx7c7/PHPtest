<?php
namespace BuscadorCEP\System;

// FIXME: 'Class not found' (Resolve apenas com require abaixo)
require 'ResponseFormat.php'; 
//use BuscadorCEP\System\XMLResponseFormat;

class Response
{
    private $format = null;
    private $data = null;

    protected function getFormat()
    {
        return $this->format;
    }
    public function __construct($statusCode, $statusData = null)
    {
        $this->format = new XMLResponseFormat();
        $this->data = [
            'code' => $statusCode,
            'data' => $statusData,
        ];
    }
    public function getData()
    {
        return $this->data;
    }
    public function send()
    {
        $this->format->process($this->data);
    }
}
