<?php
namespace controller\api;

use service\RecomendacaoService;

class RecomendacaoController
{
    public function listar()
    {
        $service = new RecomendacaoService();
        return $service->listar();
    }

    // O nome dos parâmetros aqui DEVE ser igual ao do JSON que você envia
    public function inserir($usuario_id, $genero_id, $livro_recomendado)
    {
        if(empty($usuario_id) || empty($genero_id) || empty($livro_recomendado)){
            return ["erro" => "Dados incompletos!"];
        }

        $service = new RecomendacaoService();
        $service->inserir($usuario_id, $genero_id, $livro_recomendado);
        return ["mensagem" => "Recomendação criada com sucesso!"];
    }

    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado)
    {
        $service = new RecomendacaoService();
        $service->alterar($id, $usuario_id, $genero_id, $livro_recomendado);
        return ["mensagem" => "Recomendação alterada com sucesso!"];
    }

    public function excluir($id)
    {
        $service = new RecomendacaoService();
        $service->excluir($id);
        return ["mensagem" => "Recomendação excluída com sucesso!"];
    }
}