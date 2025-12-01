<?php
namespace generic;

class Controller
{
    public function verificarChamadas($rota)
    {
        $rotas = new Rotas();
        $retorno = $rotas->executar($rota);
        
        if ($retorno) {
            header("Content-Type: application/json");
            echo json_encode($retorno);
        }
    }
}