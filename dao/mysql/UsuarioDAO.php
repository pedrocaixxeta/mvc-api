<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;
use \Exception;

class UsuarioDAO extends MysqlFactory {

    public function buscarPorEmail($email){
        // ATENÇÃO: Tem que ter a palavra "senha" aqui no meio!
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";
        
        $param = [":email" => $email];
        return $this->banco->executar($sql, $param);
    }

    public function listar(){
        try {
            $sql = "SELECT id, nome, email FROM usuarios";
            return $this->banco->executar($sql);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao listar: " . $e->getMessage()];
        }
    }

    public function inserir($nome, $email, $senha){
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $param = [":nome" => $nome, ":email" => $email, ":senha" => $senha];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao inserir: " . $e->getMessage()];
        }
    }

    // ... Mantenha alterar e excluir similares, mas com Try-Catch
    public function alterar($id, $nome, $email){
         try {
            $sql = "UPDATE usuarios SET nome=:nome, email=:email WHERE id=:id";
            $param = [":nome"=>$nome, ":email"=>$email, ":id"=>$id];
            $this->banco->executar($sql, $param);
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function excluir($id){
         try {
            $sql = "DELETE FROM usuarios WHERE id=:id";
            $param = [":id"=>$id];
            $this->banco->executar($sql, $param);
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function listarId($id){
        $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }
}