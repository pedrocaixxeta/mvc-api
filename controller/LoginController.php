<?php
namespace controller;

use service\UsuarioService;
use generic\JWTAuth;

class LoginController
{
    // A classe Acao injeta $email e $senha automaticamente do JSON
    public function logar($email, $senha)
    {
        $service = new UsuarioService();
        
        // Tenta achar o usuário e validar senha
        $usuario = $service->autenticar($email, $senha);

        if ($usuario) {
            // Se deu certo, cria o Token JWT
            $jwt = new JWTAuth();
            $token = $jwt->criarChave($usuario['id']);

            return ["token" => $token, "usuario" => $usuario['nome']];
        } else {
            return ["erro" => "Email ou senha inválidos"];
        }
    }
}