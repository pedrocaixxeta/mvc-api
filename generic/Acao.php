<?php
namespace generic;

use ReflectionMethod;

class Acao
{
    const POST = "POST";
    const GET = "GET";
    const PUT = "PUT";
    const DELETE = "DELETE";
    
    private $endpoint;

    public function __construct($endpoint = [])
    {
        $this->endpoint = $endpoint;
    }

    public function executar()
    {
        $end = $this->endpoint[$_SERVER["REQUEST_METHOD"]] ?? null;
        
        if ($end) {
            // Verifica Token JWT se necessário
            if($end->autenticar){
                $jwt = new JWTAuth();
                if(!$jwt->verificar()) return ["erro" => "Acesso não autorizado"];
            }

            // Injeção de dependência via Reflection
            $reflect = new ReflectionMethod($end->classe, $end->execucao);
            $params = $reflect->getParameters();
            $data = array_merge($_POST, $_GET, json_decode(file_get_contents("php://input"), true) ?? []);
            
            if(isset($data['param'])) unset($data['param']); // Limpa rota do GET

            $args = [];
            foreach ($params as $v) {
                $args[$v->getName()] = $data[$v->getName()] ?? null;
            }

            return $reflect->invokeArgs(new $end->classe(), $args);
        }
        return null;
    }
}