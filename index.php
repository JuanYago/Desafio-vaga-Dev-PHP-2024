<!-- index.php -->
<?php
require_once __DIR__ . "/src/Associado/associado.php";
require_once __DIR__ . "/src/Anuidade/anuidade.php";

$associado = new Associado($conexao);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/style.css">
    <title>Associação Devs do RN</title>
</head>
<body>
    <h1>Associação Devs do RN</h1>

 
    <a href="views/cadastro_associado.php">Cadastrar Associado</a>
    <a href="views/cadastro_anuidade.php">Cadastrar Anuidade</a>
    <a href="views/checkout.php">Checkout</a>
    
</body>
</html>
<?php 
