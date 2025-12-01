<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class GeneroDAO extends MysqlFactory {

    public function listar(){
        try {
            return $this->banco->executar("SELECT * FROM generos");
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function listarId($id){
        try {
            return $this->banco->executar("SELECT * FROM generos WHERE id=:id", [":id"=>$id]);
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function inserir($nome){
        try {
            $this->banco->executar("INSERT INTO generos (nome) VALUES (:n)", [":n"=>$nome]);
        } catch (PDOException $e) {
            return $e->getCode() == '23000' ? ["erro" => "Gênero já existe."] : ["erro" => $e->getMessage()];
        }
    }

    public function alterar($id, $nome){
        try {
            $this->banco->executar("UPDATE generos SET nome=:n WHERE id=:id", [":n"=>$nome, ":id"=>$id]);
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function excluir($id){
        try {
            $this->banco->executar("DELETE FROM generos WHERE id=:id", [":id"=>$id]);
        } catch (PDOException $e) {
            return $e->getCode() == '23000' ? ["erro" => "Gênero tem livros vinculados."] : ["erro" => $e->getMessage()];
        }
    }
}