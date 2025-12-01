<?php
namespace dao\mysql;

use generic\MysqlFactory;
use \PDOException;

class UsuarioDAO extends MysqlFactory {

    public function buscarPorEmail($email){
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

    public function listarId($id){
        try {
            $sql = "SELECT id, nome, email FROM usuarios WHERE id = :id";
            $param = [":id" => $id];
            return $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao buscar usuário: " . $e->getMessage()];
        }
    }

    public function inserir($nome, $email, $senha){
        try {
            $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
            $param = [":nome" => $nome, ":email" => $email, ":senha" => $senha];
            $this->banco->executar($sql, $param);
            return true;
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                return ["erro" => "O e-mail informado já está cadastrado."];
            }
            return ["erro" => "Erro ao inserir: " . $e->getMessage()];
        }
    }

    // Novo método para alteração de senha (se o Service decidir por ele)
    public function alterarComSenha($id, $nome, $email, $senha){
        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $param = [":nome" => $nome, ":email" => $email, ":senha" => $senha, ":id" => $id];
            $this->banco->executar($sql, $param);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao alterar com senha: " . $e->getMessage()];
        }
    }
    
    // Método legado (alterar sem senha) - Usado pelo Service para manter a senha antiga
    public function alterar($id, $nome, $email){
         try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id";
            $param = [":nome"=>$nome, ":email"=>$email, ":id"=>$id];
            $this->banco->executar($sql, $param);
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }

    public function excluir($id){
         try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $param = [":id" => $id];
            $this->banco->executar($sql, $param);
         } catch(PDOException $e) { return ["erro" => $e->getMessage()]; }
    }
}