<?php
include 'conexao.php';

$dataHoje = date('Y-m-d');

// Inicializa como array vazio
$agendamentosHoje = [];

$sql = "
    SELECT * FROM resumo_agendamentos
    WHERE 
        deleted_at IS NULL 
        AND status_data = 'banho'
        AND data = CURDATE()
";

$result = mysqli_query($conn, $sql);

// Verifica se houve erro na query
if (!$result) {
    die("Erro na consulta: " . mysqli_error($conn));
}

// Preenche o array com os dados
while ($row = mysqli_fetch_assoc($result)) {
    $agendamentosHoje[] = [
        'id' => $row['agendamento_id'],
        'data_id' => $row['data_id'],
        'cliente' => $row['cliente_nome'],
        'pet' => $row['pet_nome'],
        'peso' => $row['pet_peso'],
        'raca' => $row['pet_raca'],
        'idade' => $row['pet_idade'],
        'status' => $row['agendamento_status'],
        'servico' => $row['servico_nome'],
        'data' => $row['data'],
        'hora' => $row['hora'],
        'valor' => $row['valor_total'],
        'obs_cliente' => $row['obs_cliente'],
        'obs_final' => $row['obs_final'],
        //'retirada' => $row['retirada_cliente']
    ];
}

// Retorna o JSON
header('Content-Type: application/json');
echo json_encode($agendamentosHoje);
