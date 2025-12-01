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

    // POST /recomendacao
    public function inserir($usuario_id, $genero_id, $livro_recomendado)
    {
        // 1. Validação de Vazio
        if(empty($usuario_id) || empty($genero_id) || empty($livro_recomendado)){
            http_response_code(400);
            return ["erro" => "Dados incompletos! Informe usuario_id, genero_id e livro_recomendado."];
        }

        // 2. Validação de Tipo (IDs devem ser números)
        if (!is_numeric($usuario_id) || !is_numeric($genero_id)) {
            http_response_code(400);
            return ["erro" => "Os IDs de usuário e gênero devem ser numéricos."];
        }

        // 3. Validação de Tamanho (Máximo 150 caracteres)
        if (strlen($livro_recomendado) > 150) {
            http_response_code(400);
            return ["erro" => "O nome do livro é muito longo (máximo 150 caracteres)."];
        }

        $service = new RecomendacaoService();
        $resultado = $service->inserir($usuario_id, $genero_id, $livro_recomendado);
        
        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado;
        }
        
        http_response_code(201);
        return ["mensagem" => "Recomendação criada com sucesso!"];
    }

    // PUT /recomendacao
    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado)
    {
        // 1. Validação de Vazio (Essa estava faltando!)
        if (empty($id) || empty($usuario_id) || empty($genero_id) || empty($livro_recomendado)) {
            http_response_code(400);
            return ["erro" => "Dados incompletos para alteração! Envie todos os campos."];
        }

        // 2. Validação de Tamanho
        if (strlen($livro_recomendado) > 150) {
            http_response_code(400);
            return ["erro" => "O nome do livro é muito longo (máximo 150 caracteres)."];
        }

        $service = new RecomendacaoService();

        // 3. Verifica se existe antes de alterar (Evita sucesso falso)
        if (empty($service->listarId($id))) {
            http_response_code(404);
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