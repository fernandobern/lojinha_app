<?php
include 'conexao.php';

// Considerando que sua tabela tem campo deleted_at
$sql = "SELECT * FROM resumo_agendamentos WHERE data_cancelada IS NOT NULL ORDER BY data_cancelada DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>
