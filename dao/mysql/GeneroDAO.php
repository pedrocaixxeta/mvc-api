<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class GeneroDAO extends MysqlFactory {

    public function listar(){
        try {
            $sql = "SELECT * FROM generos";
            return $this->banco->executar($sql);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao listar gêneros: " . $e->getMessage()];
        }
    }

    public function listarId($id){
        try {
            $sql = "SELECT * FROM generos WHERE id = :id";
            $param = [":id" => $id];
            return $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao buscar gênero: " . $e->getMessage()];
        }
    }

    public function inserir($nome){
        // ATENÇÃO: O try começa AQUI
        try {
            $sql = "INSERT INTO generos (nome) VALUES (:nome)";
            $param = [":nome" => $nome];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            // Tratamento de duplicidade
            if ($e->getCode() == '23000') {
                return ["erro" => "Já existe um gênero cadastrado com esse nome!"];
            }
            return ["erro" => "Erro técnico ao inserir: " . $e->getMessage()];
        }
        // A função termina AQUI
    }

    public function alterar($id, $nome){
        try {
            $sql = "UPDATE generos SET nome = :nome WHERE id = :id";
            $param = [":nome" => $nome, ":id" => $id];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return ["erro" => "Já existe um gênero cadastrado com esse nome!"];
            }
            return ["erro" => "Erro técnico ao alterar: " . $e->getMessage()];
        }
    }

    public function excluir($id){
        try {
            $sql = "DELETE FROM generos WHERE id = :id";
            $param = [":id" => $id];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            // Erro de chave estrangeira (tentar apagar gênero que tem livros)
            if ($e->getCode() == '23000') {
                return ["erro" => "Não é possível excluir este gênero pois existem livros vinculados a ele."];
            }
            return ["erro" => "Erro técnico ao excluir: " . $e->getMessage()];
        }
    }
}