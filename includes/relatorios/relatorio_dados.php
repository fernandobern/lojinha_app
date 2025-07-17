<?php
include 'conexao.php';

header('Content-Type: application/json');

// Banhos por dia
$queryBanhosDia = "
    SELECT data_execucao AS data, COUNT(*) AS total
    FROM datas_execucao
    GROUP BY data_execucao
    ORDER BY data_execucao
";
$resBanhosDia = mysqli_query($conn, $queryBanhosDia);
$banhosPorDia = [];
while ($row = mysqli_fetch_assoc($resBanhosDia)) {
    $banhosPorDia[] = $row;
}

// Dia com mais banhos
$queryMaisBanhos = "
    SELECT data_execucao, COUNT(*) AS total
    FROM datas_execucao
    GROUP BY data_execucao
    ORDER BY total DESC
    LIMIT 1
";
$resMaisBanhos = mysqli_query($conn, $queryMaisBanhos);
$diaMaisMovimento = mysqli_fetch_assoc($resMaisBanhos);

// Total de banhos por mês
$queryPorMes = "
    SELECT DATE_FORMAT(data_execucao, '%Y-%m') AS mes, COUNT(*) AS total
    FROM datas_execucao
    GROUP BY mes
    ORDER BY mes
";
$resPorMes = mysqli_query($conn, $queryPorMes);
$banhosPorMes = [];
while ($row = mysqli_fetch_assoc($resPorMes)) {
    $banhosPorMes[] = $row;
}

// Serviços mais pedidos
$queryServicos = "
    SELECT s.descricao, COUNT(*) AS total
    FROM agendamento_servico ag
    JOIN servicos s ON s.id = ag.servico_id
    GROUP BY s.descricao
    ORDER BY total DESC
    LIMIT 5
";
$resServicos = mysqli_query($conn, $queryServicos);
$servicosMaisPedidos = [];
while ($row = mysqli_fetch_assoc($resServicos)) {
    $servicosMaisPedidos[] = $row;
}

// Clientes que mais agendam
$queryClientes = "
    SELECT c.nome, COUNT(*) AS total
    FROM agendamentos a
    JOIN clientes c ON c.id = a.cliente_id
    GROUP BY c.nome
    ORDER BY total DESC
    LIMIT 5
";
$resClientes = mysqli_query($conn, $queryClientes);
$clientesTop = [];
while ($row = mysqli_fetch_assoc($resClientes)) {
    $clientesTop[] = $row;
}

// Pets mais atendidos
$queryPets = "
    SELECT p.nome, COUNT(*) AS total
    FROM agendamentos a
    JOIN pets p ON p.id = a.pet_id
    GROUP BY p.nome
    ORDER BY total DESC
    LIMIT 5
";
$resPets = mysqli_query($conn, $queryPets);
$petsTop = [];
while ($row = mysqli_fetch_assoc($resPets)) {
    $petsTop[] = $row;
}

// Total e ticket médio
$queryValorTotal = "SELECT SUM(valor_total) AS total_valor, COUNT(*) AS total_banhos FROM agendamentos";
$resTotais = mysqli_query($conn, $queryValorTotal);
$valores = mysqli_fetch_assoc($resTotais);
$ticketMedio = $valores['total_banhos'] > 0 ? $valores['total_valor'] / $valores['total_banhos'] : 0;

echo json_encode([
    'banhosPorDia' => $banhosPorDia,
    'diaMaisMovimento' => $diaMaisMovimento,
    'banhosPorMes' => $banhosPorMes,
    'servicosMaisPedidos' => $servicosMaisPedidos,
    'clientesTop' => $clientesTop,
    'petsTop' => $petsTop,
    'valorTotal' => $valores['total_valor'],
    'totalBanhos' => $valores['total_banhos'],
    'ticketMedio' => round($ticketMedio, 2)
]);
