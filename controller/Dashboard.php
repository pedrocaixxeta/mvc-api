<?php
namespace controller;

use service\UsuarioService;
use service\GeneroService;
use service\RecomendacaoService;
use template\ClienteTemp;

class Dashboard
{
    public function home()
    {
        // Instancia os serviços
        $usuarioService = new UsuarioService();
        $generoService = new GeneroService();
        $recService = new RecomendacaoService();

        // Pega todos os dados
        $usuarios = $usuarioService->listar();
        $generos = $generoService->listar();
        $recomendacoes = $recService->listar();

        // Conta quantos itens tem em cada array
        $dados = [
            'qtd_usuarios' => count($usuarios),
            'qtd_generos' => count($generos),
            'qtd_recomendacoes' => count($recomendacoes),
            'ultimas_rec' => array_slice($recomendacoes, -5) // Pega as 5 últimas
        ];

        $template = new ClienteTemp();
        $template->layout("\\public\\dashboard\\home.php", $dados);
    }
}