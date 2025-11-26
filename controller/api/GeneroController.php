<?php
namespace controller\api;

use service\GeneroService;

class GeneroController
{
    public function listar($id = null)
    {
        // Instancia o serviço de GÊNERO
        $service = new GeneroService();
        
        if ($id) {
            $resultado = $service->listarId($id);
            if (empty($resultado)) {
                http_response_code(404);
                return ["erro" => "Gênero não encontrado."];
            }
            return $resultado;
        }
        
        return $service->listar();
    }

    public function inserir($nome)
    {
        if (empty($nome)) {
            http_response_code(400);
            return ["erro" => "O nome do gênero é obrigatório."];
        }
        
        $service = new GeneroService();
        $service->inserir($nome);
        return ["mensagem" => "Gênero criado com sucesso!"];
    }

    public function alterar($id, $nome)
    {
        $service = new GeneroService();
        $service->alterar($id, $nome);
        return ["mensagem" => "Gênero alterado com sucesso!"];
    }

    public function excluir($id)
    {
        $service = new GeneroService();
        $service->excluir($id);
        return ["mensagem" => "Gênero excluído com sucesso!"];
    }
}