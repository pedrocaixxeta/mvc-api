<?php

namespace controller\api;

use service\UsuarioService;

class UsuarioController
{
    // GET
    // GET: api/usuario (todos) OU api/usuario?id=1 (específico)
    public function listar($id = null)
    {
        $service = new UsuarioService();

        // Se veio um ID na URL, buscamos o específico
        if ($id) {
            $resultado = $service->listarId($id);

            // --- TRATAMENTO DE ERRO 404 ---
            // Se o array voltou vazio (empty), o ID não existe
            if (empty($resultado)) {
                http_response_code(404); // Código padrão para "Não Encontrado"
                return ["erro" => "Usuário com o ID $id não encontrado no sistema."];
            }

            return $resultado;
        } 
        
        // Se não veio ID, busca todos
        $todos = $service->listar();
        
        // Opcional: Se quiser avisar que não tem ninguém cadastrado
        if (empty($todos)) {
            return ["aviso" => "Nenhum usuário cadastrado ainda."];
        }

        return $todos;
    }

    // POST (Senha vem crua, criptografamos aqui)
    // POST: api/usuario
    public function inserir($nome, $email, $senha)
    {
        // 1. Validação de Campos Vazios (Já temos)
        if (empty($nome) || empty($email) || empty($senha)) {
            http_response_code(400);
            return ["erro" => "Dados incompletos!"];
        }

        // --- 2. NOVO: Validação de E-mail Inválido ---
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            return ["erro" => "E-mail inválido! Verifique o formato (ex: nome@dominio.com)."];
        }

        // --- 3. NOVO: Validação de Senha Fraca ---
        if (strlen($senha) < 6) {
            http_response_code(400);
            return ["erro" => "A senha deve ter pelo menos 6 caracteres."];
        }

        $service = new UsuarioService();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $resultado = $service->inserir($nome, $email, $senhaHash);
        
        if (is_array($resultado) && isset($resultado['erro'])) {
            http_response_code(500);
            return $resultado;
        }
        
        http_response_code(201);
        return ["mensagem" => "Usuário criado com sucesso!"];
    }

    // PUT
    public function alterar($id, $nome, $email)
    {
        // 1. Validação Rigorosa do PUT
        if (empty($id) || empty($nome) || empty($email)) {
            http_response_code(400);

            // TRUQUE: Colocamos o aviso junto com o erro para ele aparecer na tela
            return [
                "erro" => "Dados incompletos! Certifique-se de enviar todos os dados."
            ];
        }

        // 2. Se passou, manda bala
        $service = new UsuarioService();
        $service->alterar($id, $nome, $email);

        return ["mensagem" => "Usuário alterado com sucesso!"];
    }

    // DELETE
    // DELETE: api/usuario?id=1
    public function excluir($id)
    {
        // Validação básica se veio o ID
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID não informado para exclusão."];
        }

        $service = new UsuarioService();

        // 1. VERIFICAÇÃO: Busca o usuário antes de tentar matar ele
        $usuarioExiste = $service->listarId($id);

        // Se voltou array vazio, é porque não existe
        if (empty($usuarioExiste)) {
            http_response_code(404);
            return ["erro" => "Não foi possível excluir. O usuário com ID $id não existe."];
        }

        // 2. Se chegou aqui, ele existe. Pode apagar sem medo.
        $service->excluir($id);
        
        return ["mensagem" => "Usuário excluído com sucesso!"];
    }
}
