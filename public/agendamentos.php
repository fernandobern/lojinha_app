<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <style>
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .card {
            flex: 1 1 300px;
            background-color: #444;
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin: 10px 0;
            max-width: 400px;
        }

        .dia-section {
            margin-bottom: 40px;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 12px;
            background-color: #f9f9f9;
        }

        .dia-section h3 {
            margin-top: 0;
            color: #333;
        }

        .botoes {
            margin-top: 10px;
        }

        .botoes a {
            margin-right: 10px;
            background-color: #00aaff;
            padding: 6px 12px;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .botoes a.cancelar {
            background-color: #e74c3c;
        }

        .botoes a.editar {
            background-color: #f39c12;
        }
    </style>
</head>
<body>

<?php 
include('../templates/header.php');
include('../includes/listar_agenda.php');

// Organizar os agendamentos por data
$agendamentosPorDia = [];

while ($client_data = mysqli_fetch_assoc($result)) {
    $data = $client_data['data'];
    if (!empty($data) && $data !== '0000-00-00') {
        $agendamentosPorDia[$data][] = [
            'id' => $client_data['agendamento_id'],
            'data_id' => $client_data['data_id'],
            'data' => $client_data['data'],
            'cliente' => $client_data['cliente_nome'],
            'pet' => $client_data['pet_nome'],
            'peso' => $client_data['pet_peso'],
            'raca' => $client_data['pet_raca'],
            'idade' => $client_data['pet_idade'],
            'status' => $client_data['agendamento_status'],
            'status_data' => $client_data['status_data'],
            'servico' => $client_data['servico_nome'],
            'valor' => $client_data['valor_total'],
            'hora' => $client_data['hora'] ?? null,
            'obs_cliente' => $client_data['obs_cliente'],
            'obs_final' => $client_data['obs_final'],
            'retirada' => $client_data['retirada'],
        ];
    }
}

ksort($agendamentosPorDia);

// Mostrar o dia atual
$fmt = new IntlDateFormatter('pt_BR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'America/Sao_Paulo', IntlDateFormatter::GREGORIAN, "EEEE, d 'de' MMMM 'de' y");
$hoje = $fmt->format(new DateTime('now', new DateTimeZone('America/Sao_Paulo')));
echo "<h2 style='margin: 20px; color: white;'>Hoje é: <strong>$hoje</strong></h2>";

// Exibir agendamentos por dia
$hojeData = date('Y-m-d');

foreach ($agendamentosPorDia as $data => $agendamentos) {
    if (strtotime($data) < strtotime($hojeData)) continue;

    $fmtDia = new IntlDateFormatter('pt_BR', IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'America/Sao_Paulo', IntlDateFormatter::GREGORIAN, "EEEE");
    $diaObj = new DateTime($data, new DateTimeZone('America/Sao_Paulo'));
    $diaSemana = ucfirst($fmtDia->format($diaObj));

    $total = count($agendamentos);
    $concluidos = count(array_filter($agendamentos, fn($a) => $a['status'] === 'concluído'));

    echo "<section class='dia-section'>";
    echo "<h3>$diaSemana - $data ($total agendamentos | $concluidos concluídos)</h3>";
    echo "<div class='cards-container'>";

    foreach ($agendamentos as $a) {
        echo "<div class='card'>";
        echo "<p><strong>ID:</strong> {$a['id']}</p>";
        echo "<p><strong>Data ID:</strong> {$a['data_id']}</p>";
        echo "<p><strong>Data:</strong> {$a['data']}</p>";
        echo "<p><strong>Hora:</strong> {$a['hora']}</p>";
        echo "<p><strong>Pet:</strong> {$a['pet']} ({$a['peso']}kg, {$a['raca']}, {$a['idade']} anos)</p>";
        echo "<p><strong>Cliente:</strong> {$a['cliente']}</p>";
        echo "<p><strong>Status:</strong> {$a['status_data']}</p>";
        echo "<p><strong>Serviço:</strong> {$a['servico']} - R$ {$a['valor']}</p>";
        echo "<p><strong>Obs. Cliente:</strong> {$a['obs_cliente']}</p>";
        echo "<p><strong>Obs. Final:</strong> {$a['obs_final']}</p>";
        echo "<p><strong>Retirada:</strong> {$a['retirada']}</p>";

        // Botões de ação
        echo "<div class='botoes'>";
        echo "<a href='../includes/functions/status/setStatus.php?id={$a['data_id']}' class='retirada'>Retirar</a>";
        echo "<a href='editar_agendamento.php?id={$a['id']}' class='editar'>Editar</a>";
        echo "<a href='../includes/functions/deleteAgendamento.php?id={$a['data_id']}' class='cancelar'>Cancelar</a>";
        echo "</div>";

        // Formulário de alteração de status
        echo "<form action='../includes/functions/status/setStatus.php' method='POST'>";
        echo "<input type='hidden' name='data_id' value='{$a['data_id']}'>";
        echo "<select name='novo_status' onchange='this.form.submit()'>";
        $statusAtual = $a['status_data'];
        echo "<option value='$statusAtual'>Alterar status</option>";
        echo "<option value='retirar'>retirar</option>";
        echo "<option value='banho'>banho</option>";
        echo "<option value='concluido'>concluído</option>";
        echo "<option value='entregue'>entregue</option>";
        echo "</select>";
        echo "</form>";

        echo "</div>"; // Fecha card
    }

    echo "</div>"; // Fecha cards-container
    echo "</section>";
}
?>

<?php include '../templates/footer.php'; ?>

</body>
</html>
