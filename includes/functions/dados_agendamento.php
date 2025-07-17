<?php

//$id_agendamento = $_GET['id_agendamento'];

function obterAgendamento($id_agendamento) {
    include '../includes/conexao.php';
    $sql = "SELECT * FROM agendamentos WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $id_agendamento);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?: null;
    } else {
        //die(echo "Erro ao obter o endereço do cliente:" .$conn->error);
    }
}
?>