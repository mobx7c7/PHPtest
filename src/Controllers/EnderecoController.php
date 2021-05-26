<?php
namespace BuscadorCEP\Controllers;

use BuscadorCEP\Controllers\Controller;
use BuscadorCEP\Gateways\EnderecoGateway;
use BuscadorCEP\Helpers\ResponseHelper;
use BuscadorCEP\System\Response;
use Jarouche\ViaCEP\BuscaViaCEPXML;

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

        if ($response) {
            $response->send();
        }
    }
    private function read($cep)
    {
        $cepNumeros = preg_replace('/[^0-9]/', '', $cep);

        $gateway = $this->getGateway();

        try {
            $result = $gateway->find($cepNumeros);
            if (!empty($result)) {
                return new Response(201, $result[0]);
            } else if ($this->inserirCEP($cepNumeros)) {
                return $this->read($cepNumeros);
            } else {
                return new Response(500);
            }
        } catch (\PDOException $e) {
            return ResponseHelper::makeError(400, $e->getMessage());
        }
    }
    private function inserirCEP($cep)
    {
        try {
            $dadosCEP = $this->buscarCEP($cep);
            try {
                $gateway = $this->getGateway();
                return $gateway->insert($dadosCEP);
            } catch (\PDOException $e) {
                //if ($e->errorInfo[1] == 1062) { //Duplicate
                return ResponseHelper::makeError(400, $e->getMessage());
            }
        } catch (\Exception $e) {
            return ResponseHelper::makeError(400, $e->getMessage());
        }
    }
    private function buscarCEP($cep)
    {
        $busca = new BuscaViaCEPXML();
        return $busca->retornaCEP($this->cep);
    }
}
