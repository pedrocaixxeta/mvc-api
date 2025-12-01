<?php
namespace generic;

class Rotas
{
    private $endpoints = [];

    public function __construct()
    {
        $this->endpoints = [
            // Rota de Login (Não exige token)
            "login" => new Acao([
                Acao::POST => new Endpoint("LoginController", "logar", false)
            ]),

            // Usuários (API Completa - Exige Token)
            "usuario" => new Acao([
                Acao::GET => new Endpoint("api\\UsuarioController", "listar", true),
                Acao::POST => new Endpoint("api\\UsuarioController", "inserir", true),
                Acao::PUT => new Endpoint("api\\UsuarioController", "alterar", true),
                Acao::DELETE => new Endpoint("api\\UsuarioController", "excluir", true)
            ]),
            
            // Gêneros (API Completa - Exige Token)
            "genero" => new Acao([
                Acao::GET => new Endpoint("api\\GeneroController", "listar", true),
                Acao::POST => new Endpoint("api\\GeneroController", "inserir", true),
                Acao::PUT => new Endpoint("api\\GeneroController", "alterar", true),
                Acao::DELETE => new Endpoint("api\\GeneroController", "excluir", true)
            ]),

            // Recomendações (API Completa - Exige Token)
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
        $retorno = $this->endpoints[$rota]->executar();
        
        if ($retorno) {
            $retorno_obj = new Retorno();
            
            // Verifica se o Controller/DAO retornou um erro
            if(isset($retorno['erro'])){
                $retorno_obj->erro = $retorno['erro'];
            } else {
                $retorno_obj->dados = $retorno;
            }
            return $retorno_obj;
        }
        return null;
    }
}