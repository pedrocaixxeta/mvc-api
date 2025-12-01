<?php
namespace controller\api;

use service\RecomendacaoService;

class RecomendacaoController
{
    public function listar($id = null)
    {
        $service = new RecomendacaoService();
        if ($id) {
            $res = $service->listarId($id);
            if (empty($res)) {
                http_response_code(404);
                return ["erro" => "Recomendação não encontrada."];
            }
            return $res;
        }
        return $service->listar();
    }

    public function inserir($usuario_id, $genero_id, $livro_recomendado)
    {
        if(empty($usuario_id) || empty($genero_id) || empty($livro_recomendado)){
            return ["erro" => "Dados incompletos!"];
        }

        $service = new RecomendacaoService();
        $res = $service->inserir($usuario_id, $genero_id, $livro_recomendado);
        
        if (isset($res['erro'])) {
             http_response_code(500);
             return $res;
        }
        http_response_code(201);
        return ["mensagem" => "Recomendação criada!"];
    }

    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado)
    {
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID não informado para alteração."];
        }

        $service = new RecomendacaoService();

        $existe = $service->listarId($id);

        if (empty($existe)) {
            http_response_code(404); // Not Found
            return ["erro" => "Recomendação não encontrada para alteração."];
        }

        $res = $service->alterar($id, $usuario_id, $genero_id, $livro_recomendado);
        
        if (isset($res['erro'])) {
             http_response_code(500);
             return $res;
        }

        return ["mensagem" => "Recomendação alterada com sucesso!"];
    }

    public function excluir($id)
    {
        if (empty($id)) return ["erro" => "ID obrigatório."];

        $service = new RecomendacaoService();
        if (empty($service->listarId($id))) {
            http_response_code(404);
            return ["erro" => "Recomendação não existe."];
        }
        
        $service->excluir($id);
        return ["mensagem" => "Recomendação excluída!"];
    }
}