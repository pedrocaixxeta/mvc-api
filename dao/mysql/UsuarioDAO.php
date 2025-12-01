<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class UsuarioDAO extends MysqlFactory {

    public function buscarPorEmail($email){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        return $this->banco->executar($sql, [":email" => $email]);
    }

    public function listar(){
        try {
            return $this->banco->executar("SELECT * FROM usuarios");
        } catch (PDOException $e) { return ["erro" => "Erro: " . $e->getMessage()]; }
    }

    public function listarId($id){
        try {
            return $this->banco->executar("SELECT * FROM usuarios WHERE id=:id", [":id"=>$id]);
        } catch (PDOException $e) { return ["erro" => "Erro: " . $e->getMessage()]; }
    }

    public function inserir($nome, $email, $senha){
        try {
            $this->banco->executar(
                "INSERT INTO usuarios (nome, email, senha) VALUES (:n, :e, :s)", 
                [":n"=>$nome, ":e"=>$email, ":s"=>$senha]
            );
            return true;
        } catch (PDOException $e) {
            return $e->getCode() == '23000' ? ["erro" => "Email duplicado."] : ["erro" => $e->getMessage()];
        }
    }

    public function alterar($id, $nome, $email){
         try {
            $this->banco->executar(
                "UPDATE usuarios SET nome=:n, email=:e WHERE id=:id",
                [":n"=>$nome, ":e"=>$email, ":id"=>$id]
            );
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function alterarComSenha($id, $nome, $email, $senha){
        try {
           $this->banco->executar(
               "UPDATE usuarios SET nome=:n, email=:e, senha=:s WHERE id=:id",
               [":n"=>$nome, ":e"=>$email, ":s"=>$senha, ":id"=>$id]
           );
        } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
   }

    public function excluir($id){
         try {
            $this->banco->executar("DELETE FROM usuarios WHERE id=:id", [":id"=>$id]);
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }
}