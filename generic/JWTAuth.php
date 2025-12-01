<?php
namespace generic;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private string $key = "SuaChaveSecreta123@#$";

    public function criarChave($dados)
    {
        $hora = time();
        $payload = [
            'iat' => $hora,
            'exp' => $hora + 3600, // 1 hora
            'uid' => $dados
        ];
        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function verificar()
    {
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(401);
            return false;
        }

        $token = str_replace('Bearer ', '', $_SERVER['HTTP_AUTHORIZATION']);

        try {
            $decodificar = JWT::decode($token, new Key($this->key, 'HS256'));
            if (time() > $decodificar->exp) return false;
            return $decodificar;
        } catch (Exception $e) {
            http_response_code(401);
            return false;
        }
    }
}