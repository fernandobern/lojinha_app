

<?php
function deleteCliente($id_cliente, $conn) {
    // 1. Buscar os pets antes de "excluir"
    $selectQuery = "SELECT * FROM clientes WHERE id = ? AND deleted_at IS NULL";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param("i", $id_cliente);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $clientesExcluidos = $result->fetch_all(MYSQLI_ASSOC);

    // 2. Atualizar como excluídos (para todos os pets do cliente)
    $now = date("Y-m-d H:i:s");
    $id_cliente = $_GET['id'];
    
    $updateQuery = "UPDATE clientes SET deleted_at = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $now, $id_cliente);
    $updateStmt->execute();

    // 3. Retornar os pets que foram excluídos
    return $clientesExcluidos;
}

// Execução do processo
if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    require('../conexao.php'); // Inclua a conexão com o banco
    $excluidos = deleteCliente($id_cliente, $conn);

    // Redirecionar para a página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "ID do cliente não informado.";
}
?>