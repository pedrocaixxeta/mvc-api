<?php
namespace generic;

class Controller
{
    private $rotas = null;

    public function __construct()
    {
        $this->rotas = new Rotas();
    }

    public function verificarChamadas($rota)
    {
        $retorno = $this->rotas->executar($rota);
        
        if ($retorno) {
            header("Content-Type: application/json");
            echo json_encode($retorno);
        }
    }
}