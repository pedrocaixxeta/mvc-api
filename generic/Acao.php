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
            // 1. Verifica Token se necessário
            if($end->autenticar){
                $jwt = new JWTAuth();
                $decode = $jwt->verificar();
                if(!$decode) {
                    return ["erro" => "Acesso não autorizado"];
                }
            }

            // 2. Injeção de Dependência automática (Reflection)
            $reflectMetodo = new ReflectionMethod($end->classe, $end->execucao);
            $parametros = $reflectMetodo->getParameters();
            $returnParam = $this->getParam();
            $para = [];

            foreach ($parametros as $v) {
                $name = $v->getName();
                if(isset($returnParam[$name])){
                    $para[$name] = $returnParam[$name];
                } else {
                    $para[$name] = null; 
                }
            }

            return $reflectMetodo->invokeArgs(new $end->classe(), $para);
        }
        return null;
    }

    private function endpointMetodo()
    {
        return isset($this->endpoint[$_SERVER["REQUEST_METHOD"]]) ? $this->endpoint[$_SERVER["REQUEST_METHOD"]] : null;
    }

    private function getPost(){
        if($_POST) return $_POST;
        return [];
    }

    private function getGet(){
        if($_GET) {
            $get = $_GET;
            unset($get["param"]);
            return $get;
        }
        return [];
    }

    private function getInput(){
        $input = file_get_contents("php://input");
        if($input){
            return json_decode($input, true);
        }
        return [];
    }

    public function getParam(){
        return array_merge($this->getPost(), $this->getGet(), $this->getInput());
    }
}