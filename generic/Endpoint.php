<?php
namespace generic;

class Endpoint
{
    public $classe;
    public $execucao;
    public $autenticar;

    public function __construct($classe, $execucao, $autenticar = false)
    {
        $this->classe = "controller\\" . $classe; // Concatena namespace
        $this->execucao = $execucao;
        $this->autenticar = $autenticar;
    }
}