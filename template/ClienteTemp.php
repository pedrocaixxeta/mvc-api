<?php
namespace template;

class ClienteTemp implements ITemplate
{
    public function cabecalho()
    {
        echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <title>BookManager</title>
            <link href='https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css' rel='stylesheet'>
            <link rel='stylesheet' href='/mvc_13/public/css/estilo.css'>
        </head>
        <body>
        
        <div class='app-container'>
            <nav class='sidebar'>
                <div class='logo'>
                    <i class='ri-book-open-line'></i> BookManager
                </div>
                <div class='menu'>
                    <a href='/mvc_13/dashboard/home' class='ativo'><i class='ri-dashboard-line'></i> Dashboard</a>
                    <a href='/mvc_13/usuario/lista'><i class='ri-user-line'></i> Usuários</a>
                    <a href='/mvc_13/genero/lista'><i class='ri-price-tag-3-line'></i> Gêneros</a>
                    <a href='/mvc_13/recomendacao/lista'><i class='ri-star-line'></i> Recomendações</a>
                </div>
            </nav>

            <main class='main-content'>";
    }

    public function rodape()
    {
        echo "</main> </div> </body>
        </html>";
    }

    public function layout($caminho, $parametro = null)
    {
        $this->cabecalho();

        $raizProjeto = dirname(__DIR__);
        $caminhoCorrigido = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $caminho);
        $arquivoFinal = $raizProjeto . $caminhoCorrigido;

        if (file_exists($arquivoFinal)) {
            include $arquivoFinal;
        } else {
            echo "<div style='color:red; padding:20px;'>Erro: View não encontrada em $arquivoFinal</div>";
        }

        $this->rodape();
    }
}