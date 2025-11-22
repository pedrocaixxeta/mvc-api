<?php
namespace controller\api;

use service\UsuarioService;

class UsuarioController
{
    // GET
    public function listar($id = null)
    {
        $service = new UsuarioService();

        // Se o ID veio na URL (e não é nulo), busca só aquele
        if ($id) {
            return $service->listarId($id);
        } 
        
        // Se não veio ID, busca todos
        return $service->listar();
    }

    // POST (Senha vem crua, criptografamos aqui)
    public function inserir($nome, $email, $senha)
    {
        $service = new UsuarioService();
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        $service->inserir($nome, $email, $senhaHash);
        return ["mensagem" => "Criado com sucesso"];
    }

    // PUT
    public function alterar($id, $nome, $email)
    {
        $service = new UsuarioService();
        $service->alterar($id, $nome, $email);
        return ["mensagem" => "Alterado com sucesso"];
    }

    // DELETE
    public function excluir($id)
    {
        $service = new UsuarioService();
        $service->excluir($id);
        return ["mensagem" => "Excluído com sucesso"];
    }
}