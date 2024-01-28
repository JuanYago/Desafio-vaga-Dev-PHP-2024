
<?php
require_once __DIR__ . "/../Associado/associado.php";
 
class Anuidade {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }



    public function obterValoresAnuidade() {
        $sql = "SELECT ano, valor FROM valores_anuidades";
        $result = $this->conexao->query($sql);

        $valoresAnuidade = [];

        while ($row = $result->fetch_assoc()) {
            $valoresAnuidade[] = $row;
        }

        return $valoresAnuidade;
    }

    public function editarOuAdicionarValorAnuidade($ano, $valor) {
        $sql = "SELECT ano, valor FROM valores_anuidades WHERE ano = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bind_param("i", $ano);  
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $sql = "UPDATE valores_anuidades SET valor = ? WHERE ano = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("ds", $valor, $ano);  
            $stmt->execute();
        } else {
            $sql = "INSERT INTO valores_anuidades (ano, valor) VALUES (?, ?)";
            $stmt = $this->conexao->prepare($sql);
            $stmt->bind_param("id", $ano, $valor);  
            $stmt->execute();
        }

        return true;
    }

    
}
?>
