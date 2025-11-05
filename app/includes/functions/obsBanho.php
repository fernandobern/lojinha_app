<?php
include('../conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_id = $_POST['data_id'] ?? null;
    $obs = $_POST['obs'] ?? '';

    if ($data_id && $obs) {
        $stmt = $conn->prepare("UPDATE agendamento_datas SET observacoes_pos_banho = ? WHERE id = ?");
        $stmt->bind_param("si", $obs, $data_id);
        
        if ($stmt->execute()) {
            echo "Observação salva com sucesso!";
            header("Location: ../../public/acompanhar_dia.php");
        } else {
            echo "Erro ao salvar observação.";
        }

        $stmt->close();
    } else {
        echo "Dados incompletos.";
    }

    $conn->close();
}
?>
