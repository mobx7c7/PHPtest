<?php
namespace BuscadorCEP\Helpers;

use BuscadorCEP\System\Response;

class ResponseHelper
{
    public static function makeInvalid()
    {
        return new Response(422, ['error' => 'Invalid input']);
    }
    public static function makeNotFound()
    {
        return new Response(404, ['error' => 'Not found']);
    }
}