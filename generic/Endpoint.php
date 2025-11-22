<?php
namespace generic;

class Endpoint
{
    public $classe;
    public $execucao;
    public $autenticar;

    public function __construct($classe, $execucao, $autenticar = false)
    {
        // O professor concatena o namespace controller aqui
        $this->classe = "controller\\" . $classe;
        $this->execucao = $execucao;
        $this->autenticar = $autenticar;
    }
}