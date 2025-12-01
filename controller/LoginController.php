<?php
namespace controller;

use service\UsuarioService;
use generic\JWTAuth;

class LoginController
{
    // Método chamado na rota POST /login
    public function logar($email, $senha)
    {
        $service = new UsuarioService();
        
        // Autentica o usuário (verifica hash)
        $usuario = $service->autenticar($email, $senha);

        if ($usuario) {
            $jwt = new JWTAuth();
            // Gera o Token com o ID do usuário
            $token = $jwt->criarChave($usuario['id']);

            return ["token" => $token, "usuario" => $usuario['nome']];
        } else {
            return ["erro" => "Email ou senha inválidos"];
        }
    }
}