<?php
namespace generic;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    // Chave secreta (pode ser qualquer texto)
    private string $key = "SuaChaveSecreta123@#$";

    public function criarChave($dados)
    {
        $hora = time();
        $payload = [
            'iat' => $hora,
            'exp' => $hora + 3600,     // Expira em 1 hora
            'uid' => $dados
        ];
        
        $jwt = JWT::encode($payload, $this->key, 'HS256');
        return $jwt;
    }

    public function verificar()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(401); // Não autorizado
            return false;
        }

        $autorizacao = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $autorizacao);

        try {
            $decodificar = JWT::decode($token, new Key($this->key, 'HS256'));
            
            // Verifica validade de tempo
            $hora = time();
            if ($hora > $decodificar->exp) {
                http_response_code(401);
                return false;
            }

            return $decodificar;

        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }
}