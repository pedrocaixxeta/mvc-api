<?php
namespace controller\api;

use service\GeneroService;

class GeneroController
{
    // GET /genero (ou ?id=X)
    public function listar($id = null)
    {
        $service = new GeneroService();
        
        if ($id) {
            $resultado = $service->listarId($id);
            if (empty($resultado)) {
                http_response_code(404); // Not Found
                return ["erro" => "Gênero não encontrado."];
            }
            return $resultado;
        }
        
        return $service->listar(); // Lista todos
    }

    // POST /genero
    public function inserir($nome)
    {
        // Validação de campo obrigatório
        if (empty($nome)) {
            http_response_code(400); // Bad Request
            return ["erro" => "O nome do gênero é obrigatório."];
        }
        
        $service = new GeneroService();
        $resultado = $service->inserir($nome);
        
        // Checa se o DAO retornou erro (ex: duplicidade)
        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado;
        }

        return ["mensagem" => "Gênero criado com sucesso!"];
    }

    // PUT /genero (Altera)
    public function alterar($id, $nome)
    {
        $service = new GeneroService();
        $resultado = $service->alterar($id, $nome);
        
        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado;
        }

        return ["mensagem" => "Gênero alterado com sucesso!"];
    }

    // DELETE /genero?id=1
    public function excluir($id)
    {
        if (empty($id)) {
            http_response_code(400);
            return ["erro" => "ID não informado para exclusão."];
        }

        $service = new GeneroService();
        
        // Busca se existe para retornar 404
        $generoExiste = $service->listarId($id);

        if (empty($generoExiste)) {
            http_response_code(404);
            return ["erro" => "Não foi possível excluir. O gênero com ID $id não existe."];
        }

        // Tenta excluir e verifica erro de chave estrangeira no DAO
        $resultado = $service->excluir($id);

        if (isset($resultado['erro'])) {
             http_response_code(500);
             return $resultado; // Retorna erro do DAO (ex: "tem livros vinculados")
        }
        
        return ["mensagem" => "Gênero excluído com sucesso!"];
    }
}