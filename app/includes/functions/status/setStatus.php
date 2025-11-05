<?php
require_once '../../conexao.php'; // ajuste o caminho conforme sua estrutura

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataId = $_POST['data_id'] ?? null;
    $novoStatus = $_POST['novo_status'] ?? null;

    if ($dataId && $novoStatus) {
        $stmt = $conn->prepare("UPDATE agendamento_datas SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $novoStatus, $dataId);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: ../../../public/agendamentos.php"); // ajuste conforme sua rota
exit;
