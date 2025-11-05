<?php
include '../includes/conexao.php';

if (!isset($_GET['id'])) {
    die("ID do agendamento não informado.");
}
$agendamento_id = intval($_GET['id']);

$sql = "SELECT * FROM resumo_agendamentos WHERE agendamento_id = $agendamento_id AND deleted_at IS NULL LIMIT 1";
$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Agendamento não encontrado.");
}

$agendamento = $result->fetch_assoc();

$servicos = !empty($agendamento['servicos']) ? explode(',', $agendamento['servicos']) : [];
$valores = !empty($agendamento['valores_servicos']) ? explode(',', $agendamento['valores_servicos']) : [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Comprovante de Agendamento</title>
<link rel="stylesheet" href="../../css/config.css">
<style>
body { font-family: Arial, sans-serif; margin: 0; background: #f7f7f7; }

/* Header fixo */
header {
    position: fixed; top: 0; left: 0; width: 100%;
    background: #333; color: white; padding: 10px 20px;
    display: flex; align-items: center; justify-content: space-between;
    z-index: 1000; box-shadow: 0 2px 5px rgba(0,0,0,0.2);
}
header h2 { margin: 0; font-size: 18px; }
header a { background: #555; color: white; text-decoration: none; padding: 8px 15px; border-radius: 5px; }
header a:hover { background: #444; }

.content { padding: 80px 20px 20px; max-width: 700px; margin: auto; }
.comprovante { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 3px 8px rgba(0,0,0,0.2); }
h2, h3 { text-align: center; margin-bottom: 10px; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
table, th, td { border: 1px solid #ddd; }
th, td { padding: 10px; text-align: left; }
th { background: #4a90e2; color: white; }
.btn-print { display: block; margin: 20px auto 0; padding: 10px 20px; background: #4a90e2; color: white; text-decoration: none; border-radius: 6px; text-align: center; }
.btn-print:hover { background: #357abd; }

/* ================= Print ================= */
@media print {
    body { background: #fff; }
    header, .btn-print { display: none; }
    .content { padding: 0; margin: 0; }
    .comprovante { box-shadow: none; border-radius: 0; }
}
</style>
</head>
<body>

<header>
    <a href="clientes.php">← Voltar</a>
    <h2>Comprovante de Agendamento</h2>
    <a href="#" class="btn-print" onclick="window.print()">Imprimir</a>
</header>

<div class="content">
    <div class="comprovante">

        <p><strong>Agendamento ID:</strong> <?= $agendamento['agendamento_id'] ?? 'Não informado' ?></p>
        <p><strong>Data:</strong> <?= !empty($agendamento['data']) && !empty($agendamento['hora']) ? date('d/m/Y H:i', strtotime($agendamento['data'].' '.$agendamento['hora'])) : 'Não informado' ?></p>
        <p><strong>Status:</strong> <?= $agendamento['agendamento_status'] ?? 'Não informado' ?></p>

        <h3>Cliente</h3>
        <p><strong>Nome:</strong> <?= $agendamento['nome_cliente'] ?? 'Não informado' ?></p>
        <p><strong>Telefone:</strong> <?= $agendamento['tel'] ?? 'Não informado' ?></p>
        <p><strong>Bairro:</strong> <?= $agendamento['bairro'] ?? 'Não informado' ?></p>

        <h3>Pet</h3>
        <p><strong>Nome:</strong> <?= $agendamento['nome_pet'] ?? 'Não informado' ?></p>
        <p><strong>Raça:</strong> <?= $agendamento['pet_raca'] ?? 'Não informado' ?></p>
        <p><strong>Idade:</strong> <?= $agendamento['pet_idade'] ?? 'Não informado' ?> anos</p>
        <p><strong>Peso:</strong> <?= $agendamento['peso'] ?? 'Não informado' ?> kg</p>
        <p><strong>Observações:</strong> <?= $agendamento['observacoes_pet'] ?? 'Não informado' ?></p>

        <h3>Observações do Cliente</h3>
        <p><?= $agendamento['observacoes_cliente'] ?? 'Não informado' ?></p>

        <h3>Pós Banho</h3>
        <p><?= $agendamento['observacoes_pos_banho'] ?? 'Não informado' ?></p>

        <h3>Serviços</h3>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($servicos)): ?>
                    <?php for ($i=0; $i<count($servicos); $i++): ?>
                    <tr>
                        <td><?= htmlspecialchars($servicos[$i] ?? 'Não informado') ?></td>
                        <td>R$ <?= number_format($valores[$i] ?? 0, 2, ',', '.') ?></td>
                    </tr>
                    <?php endfor; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">Não há serviços cadastrados.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <p><strong>Valor Final:</strong> R$ <?= number_format($agendamento['valor_final'] ?? 0, 2, ',', '.') ?></p>

    </div>
</div>

</body>
</html>
