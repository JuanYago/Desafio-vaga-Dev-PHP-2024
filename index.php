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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex flex-column align-items-center">
        <img src="../public/img/logo.jpg" alt="Logo" class="my-4">
        <h1 class="my-4">Associação Devs do RN</h1>

        <div class="list-group">
            <a href="views/cadastro_associado.php" class="list-group-item list-group-item-action">Cadastrar Associado</a>
            <a href="views/cadastro_anuidade.php" class="list-group-item list-group-item-action">Cadastrar Anuidade</a>
            <a href="views/checkout.php" class="list-group-item list-group-item-action">Checkout</a>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>