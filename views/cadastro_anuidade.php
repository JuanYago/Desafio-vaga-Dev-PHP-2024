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

    <link rel="stylesheet" href="public/css/style.css">

</head>
<body>

    <div id="mensagem-erro" style="color: red;">
        <?php
        if (isset($_SESSION["mensagem_erro"])) {
            echo $_SESSION["mensagem_erro"];
            unset($_SESSION["mensagem_erro"]); 
        }

        if (isset($_SESSION["mensagem_sucesso"])) {
            echo $_SESSION["mensagem_sucesso"];
            unset($_SESSION["mensagem_sucesso"]); 
        }
        ?>
    </div>

    <h1>Administração de Anuidades</h1>


    <table>
        <tr>
            <th>Ano</th>
            <th>Valor (R$)</th>
        </tr>
        <?php foreach ($valoresAnuidade as $valor) : ?>
            <tr>
                <td><?= $valor['ano']; ?></td>
                <td><?= $valor['valor']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

 
    <h2>Editar Valores</h2>
    <form action="cadastro_anuidade.php" method="post">
        <label for="ano">Ano:</label>
        <input type="text" id="ano" name="ano" required><br>
        <label for="valor">Valor:</label>
        <input type="text" id="valor" name="valor" required><br>

        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
