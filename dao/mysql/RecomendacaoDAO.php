<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class RecomendacaoDAO extends MysqlFactory {

    public function listar(){
        try {
            $sql = "SELECT r.id, r.livro_recomendado, u.nome as usuario, g.nome as genero 
                    FROM recomendacoes r 
                    JOIN usuarios u ON r.usuario_id = u.id 
                    JOIN generos g ON r.genero_id = g.id";
            return $this->banco->executar($sql);
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function listarId($id){
        try {
            return $this->banco->executar("SELECT * FROM recomendacoes WHERE id=:id", [":id"=>$id]);
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function inserir($usuario_id, $genero_id, $livro_recomendado){
        try {
            $this->banco->executar(
                "INSERT INTO recomendacoes (usuario_id, genero_id, livro_recomendado) VALUES (:u, :g, :l)",
                [":u"=>$usuario_id, ":g"=>$genero_id, ":l"=>$livro_recomendado]
            );
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') return ["erro" => "Usuário ou Gênero inexistente."];
            return ["erro" => $e->getMessage()];
        }
    }

    public function alterar($id, $usuario_id, $genero_id, $livro_recomendado){
        try {
            $this->banco->executar(
                "UPDATE recomendacoes SET usuario_id=:u, genero_id=:g, livro_recomendado=:l WHERE id=:id",
                [":u"=>$usuario_id, ":g"=>$genero_id, ":l"=>$livro_recomendado, ":id"=>$id]
            );
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function excluir($id){
        try {
            $this->banco->executar("DELETE FROM recomendacoes WHERE id=:id", [":id"=>$id]);
        } catch (PDOException $e) { return ["erro" => $e->getMessage()]; }
    }
}