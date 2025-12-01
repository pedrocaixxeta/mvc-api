<?php
namespace service;

use dao\mysql\UsuarioDAO;

class UsuarioService extends UsuarioDAO
{
    // Método de Login
    public function autenticar($email, $senha)
    {
        $usuarios = $this->buscarPorEmail($email);

        if (!empty($usuarios)) {
            $usuario = $usuarios[0];
            // Verifica se a senha bate com o hash do banco
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario;
            }
        }
        return false;
    }

    // Método de Alteração com lógica de senha opcional
    public function alterar($id, $nome, $email, $senha = null)
    {
        if (!empty($senha)) {
            // Se tem senha, chama o DAO que atualiza a senha
            $this->alterarComSenha($id, $nome, $email, $senha);
        } else {
            // Se não tem senha, chama o DAO que mantém a antiga
            parent::alterar($id, $nome, $email);
        }
    }
}