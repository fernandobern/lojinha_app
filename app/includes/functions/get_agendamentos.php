<?php
include '../conexao.php'; // sua conexão MySQL

$query = "SELECT 
    a.id, a.cliente_id, a.pet_id, a.pacote, a.status, a.created_at,
    ad.data, ad.hora, ad.status as status_data, c.name, s.descricao
FROM agendamentos a
JOIN clientes c ON c.id = a.cliente_id
JOIN agendamento_datas ad ON ad.agendamento_id = a.id
JOIN agendamento_servico ags ON ags.agendamento_id = a.id
JOIN servicos s ON s.id = ags.servico_id
";

$result = $conn->query($query);

$eventos = [];
while ($row = $result->fetch_assoc()) {
    $eventos[] = [
        'id' => $row['id'],
        'title' => $row['name'] . ' - ' . $row['descricao'],
        'start' => $row['data'] . 'T' . $row['hora'], // deve ser 'start' (não 'data')
        'allDay' => false
    ];
}

header('Content-Type: application/json');
echo json_encode($eventos);
?>
