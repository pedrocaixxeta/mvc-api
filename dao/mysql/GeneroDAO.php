<?php
namespace dao\mysql;

use generic\MysqlFactory;

class GeneroDAO extends MysqlFactory {

    public function listar(){
        $sql = "SELECT * FROM generos";
        return $this->banco->executar($sql);
    }

    public function listarId($id){
        $sql = "SELECT * FROM generos WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }

    public function inserir($nome){
        $sql = "INSERT INTO generos (nome) VALUES (:nome)";
        $param = [":nome" => $nome];
        $this->banco->executar($sql, $param);
    }

    public function alterar($id, $nome){
        $sql = "UPDATE generos SET nome = :nome WHERE id = :id";
        $param = [
            ":nome" => $nome,
            ":id" => $id
        ];
        $this->banco->executar($sql, $param);
    }

    public function excluir($id){
        $sql = "DELETE FROM generos WHERE id = :id";
        $param = [":id" => $id];
        $this->banco->executar($sql, $param);
    }
}