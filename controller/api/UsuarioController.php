<?php
namespace controller\api;

use service\UsuarioService;

class UsuarioController
{
    // GET /usuario (ou ?id=X)
    public function listar($id = null)
    {
        $service = new UsuarioService();

        if ($id) {
            $resultado = $service->listarId($id);

            // Retorna 404 se não encontrar
            if (empty($resultado)) {
                http_response_code(404);
                return ["erro" => "Usuário com o ID $id não encontrado."];
            }
            return $resultado;
        }
        
        return $service->listar();
    }

    // POST /usuario
    public function inserir($nome, $email, $senha)
    {
        // Validação de campos obrigatórios e formato de email/senha
        if (empty($nome) || empty($email) || empty($senha)) {
            http_response_code(400);
            return ["erro" => "Dados incompletos!"];
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            return ["erro" => "E-mail inválido! Verifique o formato."];
        }
        if (strlen($senha) < 6) {
            http_response_code(400);
            return ["erro" => "A senha deve ter pelo menos 6 caracteres."];
        }

        $service = new UsuarioService();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $resultado = $service->inserir($nome, $email, $senhaHash);
        
        // Retorna 500 se o DAO retornar erro (ex: email duplicado)
        if (isset($resultado['erro'])) {
            http_response_code(500);
            return $resultado;
        }
        
        http_response_code(201);
        return ["mensagem" => "Usuário criado com sucesso!"];
    }

    // PUT /usuario
    public function alterar($id, $nome, $email, $senha = null)
    {
        // Validação estrita do PUT
        if (empty($id) || empty($nome) || empty($email)) {
            http_response_code(400);
            return ["erro" => "Dados incompletos! ID, nome e email são obrigatórios para PUT."];
        }
        
        // Lógica para hash da nova senha (se enviada)
        $senhaHash = null;
        if (!empty($senha)) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        }

        $service = new UsuarioService();
        $service->alterar($id, $nome, $email, $senhaHash); // O Service decide se atualiza a senha
        
        $msg = empty($senha) ? "Dados atualizados (senha mantida)." : "Dados e senha atualizados com sucesso!";
        
        return ["mensagem" => $msg];
    }

    // DELETE /usuario?id=X
    public function excluir($id)
    {
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID não informado para exclusão."];
        }

        $service = new UsuarioService();
        $usuarioExiste = $service->listarId($id);

        if (empty($usuarioExiste)) {
            http_response_code(404);
            return ["erro" => "Não foi possível excluir. Usuário com ID $id não existe."];
        }

        $service->excluir($id);
        
        return ["mensagem" => "Usuário excluído com sucesso!"];
    }
}