<?php
/* function deletePets($id_cliente, $conn) {
    $now = time();
    // Consulta para obter dados dos pets do cliente
    $query = "INSERT INTO pets (deleted_at)
    VALUES (?) 
    WHERE cliente_id = ?";
    
    $queryExec = $conn->prepare($query);
    $queryExec->bind_param("s", $now);
    $queryExec->execute();
    $result = $queryExec->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
    //return $result;
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit; */
?>

<?php
include ('../includes/functions/getPet.php');

function deletePets($id_cliente, $conn) {
    // 1. Buscar os pets antes de "excluir"
    $selectQuery = "SELECT * FROM pets WHERE cliente_id = ? AND deleted_at IS NULL";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param("i", $id_cliente);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $petsExcluidos = $result->fetch_all(MYSQLI_ASSOC);

    // 2. Atualizar como excluídos (para todos os pets do cliente)
    $now = date("Y-m-d H:i:s");
    $id_pet = $_GET['id'];
    $updateQuery = "UPDATE pets SET deleted_at = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("si", $now, $id_pet);
    $updateStmt->execute();

    // 3. Retornar os pets que foram excluídos
    return $petsExcluidos;
}

// Execução do processo
if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];
    require('../conexao.php'); // Inclua a conexão com o banco
    $excluidos = deletePets($id_cliente, $conn);

    // Redirecionar para a página anterior
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "ID do cliente não informado.";
}
?>