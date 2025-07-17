

<?php

include '../dataCenter/DatabaseHelper.php';

$data_id = $_GET['id'];
//function deleteAgendamento($id_agendamento, $conn) {
    // 1. Buscar os pets antes de "excluir"
    $selectQuery = "SELECT * FROM agendamento_datas WHERE id = ? AND deleted_at IS NULL";
    $selectStmt = $conn->prepare($selectQuery);
    $selectStmt->bind_param("i", $data_id);
    $selectStmt->execute();
    $result = $selectStmt->get_result();
    $deleteAgendamento = $result->fetch_all(MYSQLI_ASSOC);

    // 2. Atualizar como excluídos (para todos os pets do cliente)
    $now = date("Y-m-d");
    //$data_id = $_GET['id'];
    
    $updateQuery = "UPDATE agendamento_datas SET deleted_at = CURDATE() WHERE id = $data_id";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("ss", $now, $data_id);
    $updateStmt->execute();

     header('Location: ../../public/agendamentos.php');
    // 3. Retornar os pets que foram excluídos
    return $deleteAgendamento;
//}

//está apagando todos os agendamentos, precisaria ser somente a data que quer cancelar do agendamento específico
?>