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
        return self::makeError(404, 'Not found');
    }
    public static function makeError($status, $message)
    {
        return new Response($status, ['error' => $message]);
    }
}