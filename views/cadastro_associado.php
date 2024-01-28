<?php
$conexao = new mysqli("localhost", "root", "root", "devs_do_rn");


if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}


require_once "../src/Associado/associado.php";


$associado = new Associado($conexao);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $dataFiliacao = $_POST["data_filiacao"];

    if ($associado->cadastrarAssociado($nome, $email, $cpf, $dataFiliacao)) {
        echo "Associado cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar associado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/style.css">
    <title>Cadastro de Associados</title>

    < </head>

<body>
    <h1>Cadastro de Associados</h1>
    <form action="cadastro_associado.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br>

        <label for="data_filiacao">Data de Filiação:</label>
        <input type="date" id="data_filiacao" name="data_filiacao" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>