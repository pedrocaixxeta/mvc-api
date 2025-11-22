<?php
// Carrega as configurações do sistema
include "../generic/Autoload.php";
use generic\MysqlSingleton;

// 1. Define a senha limpa
$senhaReal = "123";

// 2. O PHP gera o hash garantido
$hashNovo = password_hash($senhaReal, PASSWORD_DEFAULT);

// 3. Atualiza direto no banco
$sql = "UPDATE usuarios SET senha = '$hashNovo' WHERE email = 'maria@email.com'";

$banco = MysqlSingleton::getInstance();
$banco->executar($sql);

echo "<h1>Sucesso!</h1>";
echo "A senha da Maria foi redefinida para: <b>123</b><br>";
echo "Hash gerado e salvo: " . $hashNovo;
?>