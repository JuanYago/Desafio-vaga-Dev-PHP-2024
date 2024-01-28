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
        echo "Anuidade paga com sucesso!";
    } else {
        echo "Erro ao pagar anuidade.";
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
</head>
<body>
    <h1>Checkout - Anuidades Devidas pelos Associados</h1>

    <?php foreach ($associados as $associado): ?>
        <h2>Associado: <?php echo $associado['nome']; ?></h2>

        <?php if (empty($associado['anuidadesDevidas'])): ?>
            <p>O associado está com o pagamento em dia.</p>
        <?php else: ?>
            <p>Valor Total Devido: R$ <?php echo number_format($associado['valorTotalDevido'], 2, ',', '.'); ?></p>

            <?php foreach ($associado['anuidadesDevidas'] as $anuidade): ?>
    <h3>Anuidade <?php echo $anuidade['ano']; ?></h3>
    <p>Valor: R$ <?php echo number_format($anuidade['valor'], 2, ',', '.'); ?></p>
    <form action="checkout.php" method="post">
        <input type="hidden" name="id_associado" value="<?php echo $associado['id']; ?>">
        <input type="hidden" name="ano" value="<?php echo $anuidade['ano']; ?>">
        <input type="submit" value="Anuidade paga">
    </form>
<?php endforeach; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>