<?php
//include ('../includes/conexao.php'); // Conexão deve estar fora da função

// Pegando o ID da URL via GET
$cliente_id = $_GET['id'] ?? null;

// Verifica se o ID foi passado corretamente e se é numérico
if (!$cliente_id || !is_numeric($cliente_id)) {
    die("Erro: ID do cliente não foi fornecido ou é inválido.");
}

function getEndereco($cliente_id, $conn) {
    $sql = "SELECT *
            FROM enderecos WHERE cliente_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $cliente_id); // Passa apenas um inteiro
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?: null; // Retorna os dados ou null
    } else {
        die("Erro na consulta de endereço: " . $conn->error);
    }
}

//$endereco = getEndereco($cliente_id, $conn);
//$endereco_id = $endereco['id'];
/* // Chamada da função
$endereco = getEndereco($cliente_id, $conn);

// Teste para ver se o endereço foi recuperado
if ($endereco) {
    echo "Endereço encontrado: " . $endereco['endereco'] . ", " . $endereco['bairro'];
} else {
    echo "Nenhum endereço encontrado para esse cliente.";
} */
?>
