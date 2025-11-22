<?php
// Cabeçalhos para permitir que o Postman acesse sem bloqueio
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

// 1. Carrega a biblioteca do JWT (Composer)
require 'vendor/autoload.php';

// 2. Carrega suas classes (Autoload manual)
include "generic/Autoload.php";

use generic\Controller;

if (isset($_GET["param"])) {
    $controller = new Controller();
    $controller->verificarChamadas($_GET["param"]);
}