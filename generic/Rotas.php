<?php
namespace generic;

class Rotas
{
    private $endpoints;

    public function __construct()
    {
        $this->endpoints = [
            "login" => new Acao([
                Acao::POST => new Endpoint("LoginController", "logar", false)
            ]),
            "usuario" => new Acao([
                Acao::GET => new Endpoint("api\\UsuarioController", "listar", true),
                Acao::POST => new Endpoint("api\\UsuarioController", "inserir", true),
                Acao::PUT => new Endpoint("api\\UsuarioController", "alterar", true),
                Acao::DELETE => new Endpoint("api\\UsuarioController", "excluir", true)
            ]),
            "genero" => new Acao([
                Acao::GET => new Endpoint("api\\GeneroController", "listar", true),
                Acao::POST => new Endpoint("api\\GeneroController", "inserir", true),
                Acao::PUT => new Endpoint("api\\GeneroController", "alterar", true),
                Acao::DELETE => new Endpoint("api\\GeneroController", "excluir", true)
            ]),
            "recomendacao" => new Acao([
                Acao::GET => new Endpoint("api\\RecomendacaoController", "listar", true),
                Acao::POST => new Endpoint("api\\RecomendacaoController", "inserir", true),
                Acao::PUT => new Endpoint("api\\RecomendacaoController", "alterar", true),
                Acao::DELETE => new Endpoint("api\\RecomendacaoController", "excluir", true)
            ]),
        ];
    }

    public function executar($rota)
    {
        if(!isset($this->endpoints[$rota])) return null;
        
        $retorno = $this->endpoints[$rota]->executar();
        
        if ($retorno) {
            $obj = new Retorno();
            if(isset($retorno['erro'])) $obj->erro = $retorno['erro'];
            else $obj->dados = $retorno;
            return $obj;
        }
        return null;
    }
}