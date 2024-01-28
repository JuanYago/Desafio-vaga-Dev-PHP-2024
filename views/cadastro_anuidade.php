<?php
session_start();

$conexao = new mysqli("localhost", "root", "root", "devs_do_rn");

if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}

require_once "../src/Anuidade/anuidade.php";

$anuidade = new Anuidade($conexao);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ano = $_POST["ano"];
    $valor = $_POST["valor"];

    if ($anuidade->editarOuAdicionarValorAnuidade($ano, $valor)) {
        $_SESSION["mensagem_sucesso"] = "Valor da anuidade atualizado com sucesso!";
    } else {
        $_SESSION["mensagem_erro"] = "Erro ao atualizar valor da anuidade.";
    }

    header("Location: cadastro_anuidade.php");
    exit();
}

$valoresAnuidade = $anuidade->obterValoresAnuidade();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administração de Anuidades</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION["mensagem_erro"])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION["mensagem_erro"] . '</div>';
            unset($_SESSION["mensagem_erro"]); 
        }

        if (isset($_SESSION["mensagem_sucesso"])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION["mensagem_sucesso"] . '</div>';
            unset($_SESSION["mensagem_sucesso"]); 
        }
        ?>

        <h1 class="my-4">Administração de Anuidades</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Ano</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($valoresAnuidade as $valor) : ?>
                    <tr>
                        <td><?= $valor['ano']; ?></td>
                        <td><?= $valor['valor']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2 class="my-4">Editar Valores</h2>
        <form action="cadastro_anuidade.php" method="post">
            <div class="form-group">
                <label for="ano">Ano:</label>
                <input type="text" id="ano" name="ano" required class="form-control">
            </div>
            <div class="form-group">
                <label for="valor">Valor:</label>
                <input type="text" id="valor" name="valor" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>