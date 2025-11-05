<?php
$mesAtual = date('m'); // mês atual (01 a 12)
$anoAtual = date('Y'); // ano atual (ex: 2025)

$sql = "SELECT COUNT(*) AS total_agendamentos_mes 
        FROM agendamentos 
        WHERE MONTH(created_at) = $mesAtual 
        AND YEAR(created_at) = $anoAtual";

$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total Agendamentos no mês",
        "valor" => $row['total_agendamentos_mes']
    ];
}
