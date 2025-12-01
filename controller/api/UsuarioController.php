<?php
namespace controller\api;

use service\UsuarioService;

class UsuarioController
{
    public function listar($id = null)
    {
        $service = new UsuarioService();
        if ($id) {
            $res = $service->listarId($id);
            if (empty($res)) {
                http_response_code(404);
                return ["erro" => "Usuário não encontrado."];
            }
            return $res;
        }
        return $service->listar();
    }

    public function inserir($nome, $email, $senha)
    {
        if (empty($nome) || empty($email) || empty($senha)) {
            http_response_code(400);
            return ["erro" => "Dados incompletos!"];
        }

        $service = new UsuarioService();
        // ATENÇÃO: Senha enviada pura (sem hash)
        $resultado = $service->inserir($nome, $email, $senha);
        
        if (isset($resultado['erro'])) {
            http_response_code(500);
            return $resultado;
        }
        
        http_response_code(201);
        return ["mensagem" => "Usuário criado com sucesso!"];
    }

    public function alterar($id, $nome, $email, $senha = null)
    {
        if (empty($id) || empty($nome) || empty($email)) {
            http_response_code(400);
            return ["erro" => "ID, nome e email são obrigatórios."];
        }

        $service = new UsuarioService();
        // Se vier senha nova, usa ela pura. Se não, usa null.
        $senhaFinal = !empty($senha) ? $senha : null;

        $service->alterar($id, $nome, $email, $senhaFinal);
        return ["mensagem" => "Dados atualizados com sucesso!"];
    }

    public function excluir($id)
    {
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID obrigatório."];
        }

        $service = new UsuarioService();
        if (empty($service->listarId($id))) {
            http_response_code(404);
            return ["erro" => "Usuário não existe."];
        }

        $service->excluir($id);
        return ["mensagem" => "Usuário excluído com sucesso!"];
    }
}