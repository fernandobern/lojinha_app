<?php
include '../includes/conexao.php';
include '../includes/functions/dados_cliente.php';
include '../includes/functions/endereco_cliente.php';


$agendamento_id = isset($_GET['id']) ? (int)$_GET['id'] : null;

$cliente = getCliente($id_cliente, $conn);


$cliente_id = null;
$pet_id = null;
$pacote = null;
$obs_cliente = '';
$datas_agendamento = [];
$servicos_agendamento = [];

if ($agendamento_id) {
    $stmt = $conn->prepare("SELECT * FROM agendamentos WHERE id = ?");
    $stmt->bind_param("i", $agendamento_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows > 0) {
        $agendamento = $resultado->fetch_assoc();
        $cliente_id = $agendamento['cliente_id'];
        $pet_id = $agendamento['pet_id'];
        $pacote = $agendamento['pacote'];
        $obs_cliente = $agendamento['observacoes_cliente'];
    }

    $cliente = getCliente($cliente_id, $conn);
    $endeco_cliente = getEndereco($cliente_id, $conn);

    // Buscar datas e horas
    $query_datas = $conn->prepare("SELECT * FROM agendamento_datas WHERE agendamento_id = ?");
    $query_datas->bind_param("i", $agendamento_id);
    $query_datas->execute();
    $result_datas = $query_datas->get_result();

    $datas_agendamento = [];
    while ($row = $result_datas->fetch_assoc()) {
        $datas_agendamento[] = $row;
    }

    // Buscar serviços
    $query_servicos = $conn->prepare("SELECT servico_id FROM agendamento_servico WHERE agendamento_id = ?");
    $query_servicos->bind_param("i", $agendamento_id);
    $query_servicos->execute();
    $result_servicos = $query_servicos->get_result();
    while ($row = $result_servicos->fetch_assoc()) {
        $servicos_agendamento[] = $row['servico_id'];
    }
}

// Buscar pets do cliente
$pets = $conn->prepare("SELECT id, name FROM pets WHERE cliente_id = ?");
$pets->bind_param("i", $cliente_id);
$pets->execute();
$resultadoPets = $pets->get_result();

// Buscar serviços disponíveisc
$servicos = $conn->query("SELECT id, descricao, valor, duracao FROM servicos");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Agendamento</title>
</head>
<body>

<?php include ('../templates/header.php'); ?>
<form action="../includes/atualizar_agendamento.php" method="POST" class="form-agendamento">
    <h2 class="titulo">Editar Agendamento</h2>
    <input type="hidden" name="agendamento_id" value="<?= $agendamento_id ?>">

    <!-- Grupo: Dados do Cliente -->
    <section class="bloco">
        <h3>Cliente</h3>
        <p><strong>ID:</strong> <?= $agendamento['cliente_id'] ?? 'Nome do cliente' ?></p>
        <p><strong>Nome:</strong> <?= $cliente['name'] ?? 'Nome do cliente' ?></p>
        <p><strong>Telefone:</strong> <?= $cliente['tel'] ?? 'Telefone' ?></p>
        <p><strong>Endereço:</strong> <?= $endeco_cliente['endereco'] ?? 'Sem endereço' ?></p>
        <p><strong>Bairro:</strong> <?= $endeco_cliente['bairro'] ?? 'Bairro não informado' ?></p>
        <p><strong>Criado em:</strong> <?= $agendamento['created_at'] ?? 'Data' ?></p>
    </section>

    <!-- Grupo: Pet + Pacote + Observações -->
    <section class="bloco">
        <h3>Pet e Pacote</h3>
        <label>Pet:
            <select name="pet_id" required>
                <?php while ($row = $resultadoPets->fetch_assoc()): ?>
                    <option value="<?= $row['id'] ?>" <?= ($row['id'] == $pet_id) ? 'selected' : '' ?>>
                        <?= $row['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </label>

        <label>Pacote:
            <select name="pacote" required>
                <option value="mensal" <?= ($pacote == 'mensal') ? 'selected' : '' ?>>Mensal</option>
                <option value="quinzenal" <?= ($pacote == 'quinzenal') ? 'selected' : '' ?>>Quinzenal</option>
                <option value="semanal" <?= ($pacote == 'semanal') ? 'selected' : '' ?>>Semanal</option>
            </select>
        </label>

        <label>Observações:
            <textarea name="obs_cliente"><?= htmlspecialchars($obs_cliente) ?></textarea>
        </label>
    </section>

    <!-- Grupo: Datas do agendamento -->
<section class="bloco">
    <h3>Datas Agendadas</h3>
    <?php if (!empty($datas_agendamento)): ?>
        <?php foreach ($datas_agendamento as $index => $ag): ?>
            <div class="linha-data">
                <span>Data <?= intval($index) + 1 ?>:</span> <br>
                <input type="number" name="[data_id]" value="<?= $ag['id'] ?>">
                <input type="date" name="datas[<?= $index ?>][data]" value="<?= $ag['data'] ?>">
                <input type="time" name="datas[<?= $index ?>][hora]" value="<?= $ag['hora'] ?>">
                <span class="status">
                    <strong>STATUS: </strong><?= htmlspecialchars($ag['status']) ?>
                </span>
                <!-- <button type="button" onclick="cancelarData(<?= $index ?>)">Cancelar</button> -->
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhuma data agendada ainda.</p>
    <?php endif; ?>
</section>



    <!-- Grupo: Serviços -->
    <section class="bloco">
        <h3>Serviços</h3>
        <?php while ($servico = $servicos->fetch_assoc()): ?>
            <label class="checkbox-item">
                <input 
                    type="checkbox" 
                    name="servicos[]" 
                    value="<?= $servico['id'] ?>" 
                    data-valor="<?= $servico['valor'] ?>" 
                    data-duracao="<?= $servico['duracao'] ?>"
                    <?= in_array($servico['id'], $servicos_agendamento) ? 'checked' : '' ?>
                >
                <?= htmlspecialchars($servico['descricao']) ?> -
                R$ <?= number_format($servico['valor'], 2, ',', '.') ?> 
                (<?= $servico['duracao'] ?> min)
            </label>
        <?php endwhile; ?>
    </section>

    <button type="submit" class="">Atualizar Agendamento</button>
</form>

<script>
    function cancelarData(i) {
        document.querySelector(`input[name="data${i}"]`).value = '';
        document.querySelector(`input[name="hora${i}"]`).value = '';
    }
</script>


</body>
</html>