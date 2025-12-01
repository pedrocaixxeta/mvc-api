<?php
namespace controller;

use service\UsuarioService;
use generic\JWTAuth;

class LoginController
{
    public function logar($email, $senha)
    {
        $service = new UsuarioService();
        $usuario = $service->autenticar($email, $senha);

        if ($usuario) {
            $jwt = new JWTAuth();
            return ["token" => $jwt->criarChave($usuario['id']), "usuario" => $usuario['nome']];
        }
        return ["erro" => "Email ou senha inválidos"];
    }
}