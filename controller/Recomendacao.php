<?php
namespace controller;

use service\RecomendacaoService;
use service\UsuarioService;
use service\GeneroService;
use template\ClienteTemp;

class Recomendacao
{
    private $template;

    public function __construct()
    {
        $this->template = new ClienteTemp();
    }

    public function listar()
    {
        $service = new RecomendacaoService();
        $resultado = $service->listar();
        $this->template->layout("\\public\\recomendacao\\listar.php", $resultado);
    }

    // Método auxiliar para carregar os dados dos dropdowns
    private function carregarDadosAuxiliares() {
        $usuarioService = new UsuarioService();
        $generoService = new GeneroService();
        
        return [
            'usuarios' => $usuarioService->listar(),
            'generos'  => $generoService->listar()
        ];
    }

    public function formulario()
    {
        // Carrega listas para o select
        $dados = $this->carregarDadosAuxiliares();
        $this->template->layout("\\public\\recomendacao\\form.php", $dados);
    }

    public function inserir()
    {
        $usuario_id = $_POST["usuario_id"];
        $genero_id = $_POST["genero_id"];
        $livro = $_POST["livro"];

        $service = new RecomendacaoService();
        $service->inserir($usuario_id, $genero_id, $livro);
        header("location: /mvc_13/recomendacao/lista");
    }

    public function alterarForm()
    {
        $id = $_GET["id"];
        $service = new RecomendacaoService();
        
        // Pega os dados dessa recomendação
        $rec = $service->listarId($id);
        
        // Pega as listas de usuarios e generos
        $dados = $this->carregarDadosAuxiliares();
        
        // Junta tudo para mandar para a tela
        $dados['recomendacao'] = $rec;

        $this->template->layout("\\public\\recomendacao\\form.php", $dados);
    }

    public function alterar()
    {
        $id = $_POST["id"];
        $usuario_id = $_POST["usuario_id"];
        $genero_id = $_POST["genero_id"];
        $livro = $_POST["livro"];

        $service = new RecomendacaoService();
        $service->alterar($id, $usuario_id, $genero_id, $livro);
        header("location: /mvc_13/recomendacao/lista");
    }

    public function excluir()
    {
        $id = $_GET["id"];
        $service = new RecomendacaoService();
        $service->excluir($id);
        header("location: /mvc_13/recomendacao/lista");
    }
}