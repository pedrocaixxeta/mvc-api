<?php
namespace generic;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private string $key = "SuaChaveSecreta123@#$"; // Chave secreta de criptografia

    public function criarChave($dados)
    {
        $hora = time();
        $payload = [
            'iat' => $hora,
            'exp' => $hora + 3600, // Token expira em 1 hora
            'uid' => $dados        // Dados do usuário (ID)
        ];
        
        return JWT::encode($payload, $this->key, 'HS256');
    }

    public function verificar()
    {
        // Checa se o cabeçalho Authorization existe
        if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
            http_response_code(401);
            return false;
        }

        $autorizacao = $_SERVER['HTTP_AUTHORIZATION'];
        $token = str_replace('Bearer ', '', $autorizacao);

        try {
            // Decodifica o token e verifica assinatura/validade
            $decodificar = JWT::decode($token, new Key($this->key, 'HS256'));
            
            // Checa se o token expirou
            if (time() > $decodificar->exp) {
                http_response_code(401);
                return false;
            }

            return $decodificar;

        } catch (Exception $e) {
            // Captura falhas na decodificação (assinatura inválida, token corrompido)
            http_response_code(401);
            return false;
        }
    }
}