<?php
include 'conexao.php';

$dataHoje = date('Y-m-d');

// Inicializa como array vazio
$agendamentosHoje = [];

$sql = "
    SELECT * FROM resumo_agendamentos
    WHERE status_data = 'banho' AND deleted_at IS NULL
    AND data = CURDATE()     
"; 

$client_data = mysqli_query($conn, $sql);

// Verifica se houve erro na query
if (!$client_data) {
    die("Erro na consulta: " . mysqli_error($conn));
}

// Preenche o array com os dados
while ($row = mysqli_fetch_assoc($client_data)) {
    $agendamentosHoje[] = [
        'id' => $row['agendamento_id'],
        'data_id' => $row['agendamento_data_id'],
        'data' => $row['data'],
        'cliente' => $row['nome_cliente'],
        'pet' => $row['nome_pet'],
        'peso' => $row['peso'],
        'raca' => $row['pet_raca'],
        'idade' => $row['pet_idade'],
        'status' => $row['agendamento_status'],
        'status_data' => $row['status_data'],
        'servico' => $row['servicos'],
        'valor' => $row['valores_servicos'],
        'hora' => $row['hora'] ?? null,
        'obs_cliente' => $row['observacoes_cliente'],
        'obs_final' => $row['observacoes_pos_banho'],
        'retirada_cliente' => $row['retirada_cliente'],
    ];
}


// Retorna o JSON
header('Content-Type: application/json');
echo json_encode($agendamentosHoje);
