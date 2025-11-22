<?php
spl_autoload_register(function($class){
    // Pega a raiz do projeto
    $diretorioBase = dirname(__DIR__);
    
    // Converte namespace em caminho de pasta (Ex: controller\api\UsuarioController -> controller/api/UsuarioController.php)
    $caminhoArquivo = $diretorioBase . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if(file_exists($caminhoArquivo)){
        include $caminhoArquivo;
    }
});