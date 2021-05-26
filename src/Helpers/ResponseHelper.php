<?php
namespace BuscadorCEP\Helpers;

use BuscadorCEP\System\Response;

class ResponseHelper
{
    public static function makeInvalidInput()
    {
        return new Response(422, ['error' => 'Invalid input']);
    }
    public static function makeNotFound()
    {
        return new Response(404, ['error' => 'Not found']);
    }
}