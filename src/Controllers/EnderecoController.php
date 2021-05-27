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
                return new Response(200, $result[0]);
            }

            try {
                $dadosViaCEP = $this->buscarCEP($cepNumeros);
                try {
                    $gateway->insert($dadosViaCEP);
                    //TODO: Non-recursive call
                    return $this->read($cep);
                } catch (\PDOException $e) {
                    return ResponseHelper::makeError(500, $e->getMessage());
                }
            } catch (\Exception $e) {
                return ResponseHelper::makeError(400, $e->getMessage()); // CEP Inválido
            }
        } catch (\PDOException $e) {
            return ResponseHelper::makeError(500, $e->getMessage());
        }
    }
    private function buscarCEP($cep)
    {
        $busca = new BuscaViaCEPXML();
        return $busca->retornaCEP($this->cep);
    }
}
