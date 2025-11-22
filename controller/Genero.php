<?php
namespace controller;

use service\GeneroService;
use template\ClienteTemp;

class Genero
{
    private $template;

    public function __construct()
    {
        $this->template = new ClienteTemp();
    }

    public function listar()
    {
        $service = new GeneroService();
        $resultado = $service->listar();
        $this->template->layout("\\public\\genero\\listar.php", $resultado);
    }

    public function formulario()
    {
        $this->template->layout("\\public\\genero\\form.php");
    }

    public function inserir()
    {
        $nome = $_POST["nome"];
        $service = new GeneroService();
        $service->inserir($nome);
        header("location: /mvc_13/genero/lista");
    }

    public function alterarForm()
    {
        $id = $_GET["id"];
        $service = new GeneroService();
        $resultado = $service->listarId($id);
        $this->template->layout("\\public\\genero\\form.php", $resultado);
    }

    public function alterar()
    {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $service = new GeneroService();
        $service->alterar($id, $nome);
        header("location: /mvc_13/genero/lista");
    }

    public function excluir()
    {
        $id = $_GET["id"];
        $service = new GeneroService();
        $service->excluir($id);
        header("location: /mvc_13/genero/lista");
    }
}