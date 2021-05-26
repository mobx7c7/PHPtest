<?php
namespace BuscadorCEP\Controllers;

use BuscadorCEP\Controllers\Controller;
use BuscadorCEP\Gateways\EnderecoGateway;
use BuscadorCEP\System\Response;
use BuscadorCEP\Helpers\ResponseHelper;
use BuscadorCEP\Helpers\XMLHelper;

class EnderecoController extends Controller
{
    private $cep;

    public function __construct($db, $method, $cep)
    {
        Controller::__construct($method, new EnderecoGateway($db));
        $this->cep = $cep;
    }
    public function process()
    {
        switch ($this->getMethod()) {
            case 'GET':
                $response = $this->read($this->cep);
                break;
            default:
                $response = ResponseHelper::makeNotFound();
                break;
        }

        if($response)
            $response->send();
    }
    private function read($id)
    {
        //TODO: Implementation
    }
}
