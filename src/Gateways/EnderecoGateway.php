<?php
namespace BuscadorCEP\Gateways;

use BuscadorCEP\Gateways\Gateway;

class EnderecoGateway extends Gateway
{
    public function __construct($db)
    {
        Gateway::__construct($db);
    }
    public function find($cep)  
    {
        $stmt = <<<EOS
        SELECT 
            cep, logradouro, complemento, bairro, localidade, uf 
        FROM endereco WHERE cep = ?;
        EOS;

        $db = $this->getConnection();

        $stmt = $db->prepare($stmt);

        $stmt->execute(array($cep));
        
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function insert(array $input)
    {
        $stmt = <<<EOS
        INSERT INTO endereco 
            (cep, logradouro, complemento, bairro, localidade, uf) 
        VALUES
            (:cep, :logradouro, :complemento, :bairro, :localidade, :uf);
        EOS;
        
        $db = $this->getConnection();
        
        $stmt = $db->prepare($stmt);

        $stmt->execute(array(
            'cep' => preg_replace('/[^0-9]/', '', $input['cep']),
            'logradouro' => $input['logradouro'],
            'complemento' => $input['complemento'],
            'bairro' => $input['bairro'],
            'localidade' => $input['localidade'],
            'uf' => $input['uf']
        ));

        return $stmt->rowCount();
    }
}
