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
        echo '<div class="alert alert-success" role="alert">Associado cadastrado com sucesso!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Erro ao cadastrar associado.</div>';
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Cadastro de Associados</h1>
        <form action="cadastro_associado.php" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required class="form-control">
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required class="form-control">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" required class="form-control">
            </div>
            <div class="form-group">
                <label for="data_filiacao">Data de Filiação:</label>
                <input type="date" id="data_filiacao" name="data_filiacao" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>