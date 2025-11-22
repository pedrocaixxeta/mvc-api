<?php
namespace dao\mysql;

use generic\MysqlFactory;

class RecomendacaoDAO extends MysqlFactory {

    public function listar(){
        // O "Pulo do Gato": Trazemos o nome do usuario e do genero junto com a recomendação
        $sql = "SELECT r.id, r.livro_recomendado, u.nome as nome_usuario, g.nome as nome_genero 
                FROM recomendacoes r 
                JOIN usuarios u ON r.usuario_id = u.id 
                JOIN generos g ON r.genero_id = g.id";
        
        return $this->banco->executar($sql);
    }

    public function listarId($id){
        $sql = "SELECT * FROM recomendacoes WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }

    public function inserir($usuario_id, $genero_id, $livro){
        $sql = "INSERT INTO recomendacoes (usuario_id, genero_id, livro_recomendado) 
                VALUES (:usuario_id, :genero_id, :livro)";
        $param = [
            ":usuario_id" => $usuario_id,
            ":genero_id" => $genero_id,
            ":livro" => $livro
        ];
        $this->banco->executar($sql, $param);
    }

    public function alterar($id, $usuario_id, $genero_id, $livro){
        $sql = "UPDATE recomendacoes SET usuario_id=:u, genero_id=:g, livro_recomendado=:l WHERE id=:id";
        $param = [
            ":u" => $usuario_id,
            ":g" => $genero_id,
            ":l" => $livro,
            ":id" => $id
        ];
        $this->banco->executar($sql, $param);
    }

    public function excluir($id){
        $sql = "DELETE FROM recomendacoes WHERE id = :id";
        $param = [":id" => $id];
        $this->banco->executar($sql, $param);
    }
}