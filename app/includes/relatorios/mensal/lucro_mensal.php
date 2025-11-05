<?php
$mesAtual = date('m');
$anoAtual = date('Y');

$sql = "
SELECT SUM(s.valor) AS lucro_mensal
FROM servicos s
JOIN agendamento_servico ags ON ags.servico_id = s.id
JOIN agendamentos a ON a.id = ags.agendamento_id
WHERE MONTH(a.created_at) = $mesAtual
  AND YEAR(a.created_at) = $anoAtual
  AND a.deleted_at IS NULL
";


$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Lucro Mensal Banho e Tosa",
        "valor" => $row['lucro_mensal'] ?? 0
    ];
}
?>
