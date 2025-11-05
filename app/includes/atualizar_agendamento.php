<?php
include '../includes/conexao.php';

// Verifica se veio um ID válido
$agendamento_id = isset($_POST['agendamento_id']) ? (int)$_POST['agendamento_id'] : null;

if (!$agendamento_id) {
    echo "ID do agendamento inválido.";
    exit;
}

// Dados principais
$data_id = $_POST['data_id'] ?? null;
$pet_id = $_POST['pet_id'] ?? null;
$pacote = $_POST['pacote'] ?? null;
$obs_cliente = $_POST['obs_cliente'] ?? '';
$datas = $_POST['datas'] ?? [];
$servicos = $_POST['servicos'] ?? [];

$conn->begin_transaction();

try {
    // Atualiza agendamentos
    $stmt = $conn->prepare("UPDATE agendamentos SET pet_id = ?, pacote = ?, obs_cliente = ? WHERE id = ?");
    $stmt->bind_param("issi", $pet_id, $pacote, $obs_cliente, $agendamento_id);

    $stmt->execute();

    $update_data = $conn->prepare("UPDATE agendamento_datas SET data = ?, hora = ? WHERE id = ?");
    foreach ($datas as $d) {
        if (!empty($d['data']) && !empty($d['hora'])) {
            $update_data->bind_param("iss", $data_id, $d['data'], $d['hora']);
            $update_data->execute();
        }
    }

    // Atualiza os serviços
   /*  $delete_servicos = $conn->prepare("DELETE FROM agendamento_servicos WHERE agendamento_id = ?");
    $delete_servicos->bind_param("i", $agendamento_id);
    $delete_servicos->execute(); */

    $insert_servico = $conn->prepare("INSERT INTO agendamento_servicos (agendamento_id, servico_id) VALUES (?, ?)");
    foreach ($servicos as $servico_id) {
        $insert_servico->bind_param("ii", $agendamento_id, $servico_id);
        $insert_servico->execute();
    }

    $conn->commit();

    header("Location: ../public/acompanhar_dia.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo "Erro ao atualizar agendamento: " . $e->getMessage();
    exit;
}
?>
