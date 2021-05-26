<?php
namespace BuscadorCEP\System;

use BuscadorCEP\Helpers\XMLHelper;

interface ResponseFormat
{
    public function process($response);
}

class XMLResponseFormat implements ResponseFormat
{
    public function process($response)
    {
        http_response_code($response['code']);
        if ($response['data']) {
            header('Content-Type: application/xml');
            echo XMLHelper::encode('BuscadorCEP', $response['data']);
        }
    }
}
