<?php
namespace service;

use dao\mysql\UsuarioDAO;

class UsuarioService extends UsuarioDAO
{
    public function autenticar($email, $senha)
    {
        $usuarios = $this->buscarPorEmail($email);
        if (!empty($usuarios)) {
            // ATENÇÃO: Comparação direta (Texto == Texto)
            if ($senha == $usuarios[0]['senha']) {
                return $usuarios[0];
            }
        }
        return false;
    }

    public function alterar($id, $nome, $email, $senha = null)
    {
        if (!empty($senha)) {
            $this->alterarComSenha($id, $nome, $email, $senha);
        } else {
            parent::alterar($id, $nome, $email);
        }
    }
}