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
        $end = $this->endpointMetodo();
        
        if ($end) {
            // 1. JWT Middleware: Verifica se a rota precisa de Token
            if($end->autenticar){
                $jwt = new JWTAuth();
                $decode = $jwt->verificar();
                if(!$decode) {
                    return ["erro" => "Acesso não autorizado"];
                }
            }

            // 2. Reflection: Prepara a injeção de parâmetros
            $reflectMetodo = new ReflectionMethod($end->classe, $end->execucao);
            $parametros = $reflectMetodo->getParameters();
            $returnParam = $this->getParam(); // Coleta dados do JSON, POST e GET
            $para = [];

            // 3. Injeta parâmetros por nome (automaticamente)
            foreach ($parametros as $v) {
                $name = $v->getName();
                $para[$name] = $returnParam[$name] ?? null; // Null coalescing para null se não existir
            }

            // 4. Executa o método do Controller com os argumentos injetados
            return $reflectMetodo->invokeArgs(new $end->classe(), $para);
        }
        return null;
    }

    private function endpointMetodo()
    {
        // Mapeia o verbo HTTP (GET/POST/PUT/DELETE) para o Endpoint configurado
        return $this->endpoint[$_SERVER["REQUEST_METHOD"]] ?? null;
    }

    private function getPost(){
        return $_POST ?? [];
    }

    private function getGet(){
        if($_GET) {
            $get = $_GET;
            unset($get["param"]); // Remove o parametro de rota
            return $get;
        }
        return [];
    }

    private function getInput(){
        $input = file_get_contents("php://input");
        if($input){
            return json_decode($input, true); // Retorna array do JSON Body
        }
        return [];
    }

    public function getParam(){
        // Junta todos os dados recebidos (JSON, GET, POST)
        return array_merge($this->getPost(), $this->getGet(), $this->getInput());
    }
}