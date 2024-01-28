<?php
$conexao = new mysqli("localhost", "root", "root", "devs_do_rn");

if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}

require_once "../src/Associado/associado.php";

$associadoObj = new Associado($conexao);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idAssociado = $_POST['id_associado'];
    $ano = $_POST['ano'];

    if ($associadoObj->pagarAnuidade($idAssociado, $ano)) {
        echo '<div class="alert alert-success" role="alert">Anuidade paga com sucesso!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Erro ao pagar anuidade.</div>';
    }
}

$associados = $associadoObj->listarAssociados();

foreach ($associados as &$associado) {
    $resultadoCheckout = $associadoObj->calcularAnuidadesDevidas($associado['id'], date("Y"));
    $associado['anuidadesDevidas'] = $resultadoCheckout['anuidades'];
    $associado['valorTotalDevido'] = $resultadoCheckout['valorTotal'];
}
unset($associado);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Anuidades Devidas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Checkout - Anuidades Devidas pelos Associados</h1>

        <?php foreach ($associados as $associado): ?>
            <div class="card my-4">
                <div class="card-header">
                    Associado: <?php echo $associado['nome']; ?>
                </div>
                <div class="card-body">
                    <?php if (empty($associado['anuidadesDevidas'])): ?>
                        <p class="card-text">O associado está com o pagamento em dia.</p>
                    <?php else: ?>
                        <p class="card-text">Valor Total Devido: R$ <?php echo number_format($associado['valorTotalDevido'], 2, ',', '.'); ?></p>

                        <?php foreach ($associado['anuidadesDevidas'] as $anuidade): ?>
                            <h3 class="card-title">Anuidade <?php echo $anuidade['ano']; ?></h3>
                            <p class="card-text">Valor: R$ <?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></p>
                            <form action="checkout.php" method="post">
                                <input type="hidden" name="id_associado" value="<?php echo $associado['id']; ?>">
                                <input type="hidden" name="ano" value="<?php echo $anuidade['ano']; ?>">
                                <button type="submit" class="btn btn-primary">Anuidade paga</button>
                            </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>