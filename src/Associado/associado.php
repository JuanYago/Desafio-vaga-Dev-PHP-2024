
<?php
require_once __DIR__ . "/../Anuidade/anuidade.php";


class Associado {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function cadastrarAssociado($nome, $email, $cpf, $dataFiliacao) {
        $sql = "INSERT INTO associados (nome, email, cpf, data_filiacao) VALUES (?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $cpf, $dataFiliacao);
        $stmt->execute();

        $idAssociado = $this->conexao->insert_id;

        $anoFiliacao = date("Y", strtotime($dataFiliacao));
        $anoAtual = date("Y");

        for ($ano = $anoFiliacao; $ano <= $anoAtual; $ano++) {
            $sqlAnuidade = "SELECT valor FROM valores_anuidades WHERE ano = ?";
            $stmtAnuidade = $this->conexao->prepare($sqlAnuidade);
            $stmtAnuidade->bind_param("i", $ano);
            $stmtAnuidade->execute();
            $resultAnuidade = $stmtAnuidade->get_result();
            $valorAnuidade = $resultAnuidade->fetch_assoc()['valor'];

            $sqlAssociadoAnuidade = "INSERT INTO anuidades_associados (id_associado, ano, valor, pago) VALUES (?, ?, ?, 0)";
            $stmtAssociadoAnuidade = $this->conexao->prepare($sqlAssociadoAnuidade);
            $stmtAssociadoAnuidade->bind_param("iid", $idAssociado, $ano, $valorAnuidade);
            $stmtAssociadoAnuidade->execute();
            if ($stmtAssociadoAnuidade->error) {
                return false;
            }
            
        }

        return true;
    }

    public function calcularAnuidadesDevidas($idAssociado, $anoBase) {
        $sql = "SELECT a.ano, a.valor, a.pago 
                FROM anuidades_associados a
                WHERE a.id_associado = ? AND a.ano <= ? AND a.pago = 0";
    
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ii", $idAssociado, $anoBase);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $anuidadesDevidas = [];
        $valorTotalDevido = 0;
    
        while ($row = $result->fetch_assoc()) {
            $ano = $row['ano'];
            $valor = $row['valor'];
    
            $anuidadesDevidas[] = [
                'ano' => $ano,
                'valor' => $valor,
                'pago' => $row['pago']
            ];
    
            if ($row['pago'] == 0) {
                $valorTotalDevido += $valor;
            }
        }
    
        return ['anuidades' => $anuidadesDevidas, 'valorTotal' => $valorTotalDevido];
    }

    public function pagarAnuidade($idAssociado, $ano) {
        $sql = "UPDATE anuidades_associados SET pago = 1 WHERE id_associado = ? AND ano = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("ii", $idAssociado, $ano);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function listarAssociados() {
        $sql = "SELECT * FROM associados";
        $resultado = $this->conexao->query($sql);

        if ($resultado === false) {
            die("Erro ao buscar associados: " . $this->conexao->error);
        }

        $associados = $resultado->fetch_all(MYSQLI_ASSOC);

        return $associados;
    }
}

