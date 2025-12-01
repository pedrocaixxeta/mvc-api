<?php
namespace controller\api;

use service\GeneroService;

class GeneroController
{
    public function listar($id = null)
    {
        $service = new GeneroService();
        if ($id) {
            $res = $service->listarId($id);
            if (empty($res)) {
                http_response_code(404);
                return ["erro" => "Gênero não encontrado."];
            }
            return $res;
        }
        return $service->listar();
    }

    public function inserir($nome)
    {
        if (empty($nome)) return ["erro" => "Nome obrigatório."];
        
        $service = new GeneroService();
        $res = $service->inserir($nome);
        
        if (isset($res['erro'])) {
             http_response_code(500);
             return $res;
        }
        return ["mensagem" => "Gênero criado!"];
    }

    public function alterar($id, $nome)
    {
        $service = new GeneroService();
        $res = $service->alterar($id, $nome);
        if (isset($res['erro'])) {
             http_response_code(500);
             return $res;
        }
        return ["mensagem" => "Gênero alterado!"];
    }

    public function excluir($id)
    {
        if (empty($id)) return ["erro" => "ID obrigatório."];

        $service = new GeneroService();
        if (empty($service->listarId($id))) {
            http_response_code(404);
            return ["erro" => "Gênero não existe."];
        }

        $res = $service->excluir($id);
        if (isset($res['erro'])) {
             http_response_code(500);
             return $res;
        }
        return ["mensagem" => "Gênero excluído!"];
    }
}