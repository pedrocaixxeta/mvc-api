<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class RecomendacaoDAO extends MysqlFactory {

    public function listar(){
        try {
            // SQL com JOIN para trazer nomes de usuário e gênero
            $sql = "SELECT r.id, r.livro_recomendado, u.nome as usuario, g.nome as genero 
                    FROM recomendacoes r 
                    JOIN usuarios u ON r.usuario_id = u.id 
                    JOIN generos g ON r.genero_id = g.id";
            return $this->banco->executar($sql);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao listar recomendações: " . $e->getMessage()];
        }
    }

    public function listarId($id){
        try {
            $sql = "SELECT * FROM recomendacoes WHERE id = :id";
            $param = [":id" => $id];
            return $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao buscar recomendação: " . $e->getMessage()];
        }
    }

    public function inserir($usuario_id, $genero_id, $livro_recomendado){
        try {
            $sql = "INSERT INTO recomendacoes (usuario_id, genero_id, livro_recomendado) 
                    VALUES (:u, :g, :l)";
            $param = [":u" => $usuario_id, ":g" => $genero_id, ":l" => $livro_recomendado];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            // Tratamento de erro de chave estrangeira
            if ($e->getCode() == '23000') { 
                 if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                     return ["erro" => "O Usuário ou o Gênero informado não existe no banco de dados."];
                 }
            }
            return ["erro" => "Erro técnico ao criar recomendação: " . $e->getMessage()];
        }
    }

    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado){
        try {
            $sql = "UPDATE recomendacoes SET usuario_id=:u, genero_id=:g, livro_recomendado=:l WHERE id=:id";
            $param = [":u" => $usuario_id, ":g" => $genero_id, ":l" => $livro_recomendado, ":id" => $id];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            // Tratamento de erro de chave estrangeira
            if ($e->getCode() == '23000') { 
                 if (strpos($e->getMessage(), 'foreign key constraint fails') !== false) {
                     return ["erro" => "O Usuário ou o Gênero informado não existe no banco de dados."];
                 }
            }
            return ["erro" => "Erro técnico ao alterar: " . $e->getMessage()];
        }
    }

    public function excluir($id){
        try {
            $sql = "DELETE FROM recomendacoes WHERE id = :id";
            $param = [":id" => $id];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao excluir: " . $e->getMessage()];
        }
    }
}