<?php
namespace controller\api;

use service\RecomendacaoService;

class RecomendacaoController
{
    // GET /recomendacao (ou ?id=X)
    public function listar($id = null)
    {
        $service = new RecomendacaoService();
        
        if ($id) {
            $resultado = $service->listarId($id);
            if (empty($resultado)) {
                http_response_code(404);
                return ["erro" => "Recomendação não encontrada."];
            }
            return $resultado;
        }
        
        return $service->listar();
    }

    // POST /recomendacao (Cria nova recomendação)
    public function inserir($usuario_id, $genero_id, $livro_recomendado)
    {
        // Validação de campos obrigatórios
        if(empty($usuario_id) || empty($genero_id) || empty($livro_recomendado)){
            http_response_code(400);
            return ["erro" => "Dados incompletos! O ID de usuário e gênero são obrigatórios."];
        }

        $service = new RecomendacaoService();
        $resultado = $service->inserir($usuario_id, $genero_id, $livro_recomendado);
        
        // Checa erros do DAO (ex: Foreign Key violation)
        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado;
        }
        http_response_code(201);
        return ["mensagem" => "Recomendação criada com sucesso!"];
    }

    // PUT /recomendacao (Altera)
    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado)
    {
        $service = new RecomendacaoService();
        $resultado = $service->alterar($id, $usuario_id, $genero_id, $livro_recomendado);
        
        // Checa erros do DAO (ex: Foreign Key violation)
        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado;
        }

        return ["mensagem" => "Recomendação alterada com sucesso!"];
    }

    // DELETE /recomendacao?id=1
    public function excluir($id)
    {
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID não informado."];
        }

        $service = new RecomendacaoService();

        // Busca a recomendação (checa existência)
        $recomendacaoExiste = $service->listarId($id);

        if (empty($recomendacaoExiste)) {
            http_response_code(404);
            return ["erro" => "Não foi possível excluir. A recomendação com ID $id não existe."];
        }
        
        // Tenta excluir
        $service->excluir($id);
        
        return ["mensagem" => "Recomendação excluída com sucesso!"];
    }
}