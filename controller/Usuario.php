<?php
namespace controller;

use service\UsuarioService;
use template\ClienteTemp; // Vamos reutilizar o template visual que já criamos, pois é só HTML/CSS

class Usuario
{
    private $template;

    public function __construct()
    {
        $this->template = new ClienteTemp();
    }

    public function listar()
    {
        $service = new UsuarioService();
        $resultado = $service->listar();
        // Atenção: Pasta nova 'usuario'
        $this->template->layout("\\public\\usuario\\listar.php", $resultado);
    }

    public function formulario()
    {
        $this->template->layout("\\public\\usuario\\form.php");
    }

    public function inserir()
    {
        $nome = $_POST["nome"];
        $email = $_POST["email"]; // Trocamos endereco por email
        
        $service = new UsuarioService();
        $service->inserir($nome, $email);
        
        header("location: /mvc_13/usuario/lista");
    }

    public function alterarForm()
    {
        $id = $_GET["id"];
        $service = new UsuarioService();
        $resultado = $service->listarId($id);
        $this->template->layout("\\public\\usuario\\form.php", $resultado);
    }

    public function alterar()
    {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        
        $service = new UsuarioService();
        $service->alterar($id, $nome, $email);
        
        header("location: /mvc_13/usuario/lista");
    }

    public function excluir()
    {
        $id = $_GET["id"];
        $service = new UsuarioService();
        $service->excluir($id);
        
        header("location: /mvc_13/usuario/lista");
    }
}