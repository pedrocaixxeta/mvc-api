<?php
namespace service;

use dao\mysql\UsuarioDAO;

class UsuarioService extends UsuarioDAO
{
    public function autenticar($email, $senha)
    {
        $usuarios = $this->buscarPorEmail($email);

        if (!empty($usuarios)) {
            $usuario = $usuarios[0];
            // Verifica o hash da senha
            if (password_verify($senha, $usuario['senha'])) {
                return $usuario;
            }
        }
        return false;
    }
}