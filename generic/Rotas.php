<?php
namespace generic;

class Rotas
{
    private $endpoints = [];

    public function __construct()
    {
        // Mapeamento das Rotas
        // Estrutura: "URL" => new Acao([ VERBO => new Endpoint("Classe", "Metodo", PrecisaSenha?) ])
        
        $this->endpoints = [
            // Rota de Login (Gera o token - Autenticar false)
            "login" => new Acao([
                Acao::POST => new Endpoint("LoginController", "logar", false)
            ]),

            // Rotas de Usuário (Todas exigem token - Autenticar true)
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

            // Recomendações
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
        if (isset($this->endpoints[$rota])) {
            $endpoint = $this->endpoints[$rota];
            $dados = $endpoint->executar();
            
            $retorno = new Retorno();
            if(isset($dados['erro'])){
                $retorno->erro = $dados['erro'];
            } else {
                $retorno->dados = $dados;
            }
            return $retorno;
        }
        return null;
    }
}