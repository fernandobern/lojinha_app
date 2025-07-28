<?php
include '../templates/header.php';
include '../includes/conexao.php'; // Inclui a conexão com o banco
include '../includes/functions/dados_cliente.php';
include '../includes/functions/endereco_cliente.php';
include '../includes/functions/dados_agendamento.php';
include '../includes/functions/petCliente.php';
include '../includes/functions/getServices.php';

// Buscar endereço do cliente (usando função externa)
$id_agendamento = $_GET['id'];
$agendamento = obterAgendamento($id_agendamento, $conn);
$cliente_id = $agendamento['cliente_id'];
$endereco = getEndereco($cliente_id, $conn);
$pets = getPets($id_agendamento, $conn);
$servicos = getServices($conn);
$cliente = getCliente($cliente_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <title>Agendamento</title>
</head>
<body>
    <br>
    <br>
<section class="container">
    <div class="">
        <!-- Exibe o nome do cliente ou uma mensagem de erro -->
        <div class="container">
            <?php if ($agendamento): ?>
                <span>
                    <h1 class="title">Agendamento ID:</h1>
                    <h3 class="sub-title"><?php echo htmlspecialchars($agendamento['id']); ?></h3>
                    <h3 class="sub-title">Cliente ID:<?php echo htmlspecialchars($agendamento['cliente_id']); ?></h3>
                    <h3 class="sub-title">Cliente:<?php echo htmlspecialchars($cliente['name']); ?></h3>
                    <h3 class="sub-title">Bairro:<?php echo htmlspecialchars($endereco['rua']); ?></h3>
                    <h3 class="sub-title">Rua:<?php echo htmlspecialchars($endereco['bairro']); ?></h3>
                </span>
            <?php else: ?>
                <h2><?php echo 'No momento não existe agendamento selecionado!'; ?></h2>
            <?php endif; ?>
        </div>            

    <form class="form-box-auto" action="../includes/functions/salvarAgendamento.php" method="POST">
    <input type="number" name="agendamento_id" value="<?php echo htmlspecialchars($agendamento['id']); ?>" readonly>
    <input type="number" name="cliente_id" value="<?php echo htmlspecialchars($agendamento['cliente_id']); ?>" readonly>
    <input type="text" name="cliente_nome" value="<?php echo htmlspecialchars($cliente['name']); ?>" readonly>
    <input type="number" name="endereco_id" value="<?php echo htmlspecialchars($agendamento['endereco_id']); ?>" readonly>
    <input type="text" name="rua" value="<?php echo htmlspecialchars($endereco['rua']); ?>" readonly>


    <!-- Seleção de PET -->
    <fieldset>
        <legend>Selecionar Pet</legend>
        <table class="table" style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Peso</th>
                <th>Sexo</th>
                <th>Selecionar</th>
            </tr>
            <?php foreach ($pets as $pet) : ?>
                <tr>
                    <td><?= htmlspecialchars($pet['id']) ?></td>
                    <td><?= htmlspecialchars($pet['name']) ?></td>
                    <td><?= htmlspecialchars($pet['peso']) ?></td>
                    <td><?= htmlspecialchars($pet['sexo']) ?></td>
                    <td>
                        <input type="radio" name="pet_id" value="<?= $pet['id'] ?>" required>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>

    <!-- Seleção de Serviços -->
    <fieldset>
        <legend>Selecionar Serviços</legend>
        <table class="table" style="width: 100%;">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Valor</th>
                <th>Duração</th>
                <th>Selecionar</th>
            </tr>
            <?php foreach ($servicos as $servico) : ?>
                <tr>
                    <td><?= $servico['id'] ?></td>
                    <td><?= $servico['descricao'] ?></td>
                    <td><?= $servico['valor'] ?></td>
                    <td><?= $servico['duracao'] ?></td>
                    <td>
                        <input type="checkbox" name="servico[]" value="<?= $servico['id'] ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </fieldset>

    <!-- Pacote -->
    <fieldset>
        <legend>Tipo de Pacote</legend>
        <?php 
        $pacotes = ["Mensal", "Semestral", "Trimestral", "Avulso"];
        foreach ($pacotes as $tipo) :
        ?>
            <label>
                <input type="radio" name="pacote" value="<?= $tipo ?>"> <?= $tipo ?>
            </label>
        <?php endforeach; ?>
    </fieldset>

    <!-- Datas e Horários -->
    <fieldset>
        <legend>Datas e Horários</legend>
        <?php for ($i = 0; $i < 4; $i++) : ?>
            <div class="form-box">
                <label for="data<?= $i ?>">Data <?= $i + 1 ?>:</label>
                <input type="date" id="data<?= $i ?>" name="datas[<?= $i ?>][data]">

                <label for="hora<?= $i ?>">Hora <?= $i + 1 ?>:</label>
                <input type="time" id="hora<?= $i ?>" name="datas[<?= $i ?>][hora]">

                <label for="status<?= $i ?>">Status do serviço:</label>
                <select name="datas[<?= $i ?>][status_banho]">
                    <option value="pendente">Pendente</option>
                    <option value="banho">Banho</option>
                    <option value="concluído">Concluído</option>
                </select>
            </div>
        <?php endfor; ?>
    </fieldset>


    <!-- Observações -->
    <div class="form-box">
        <label for="obs_cliente">Observações:</label><br>
        <textarea name="obs_cliente" id="obs_cliente" rows="4" cols="50" placeholder="Ex: alergias, machucados, doenças..."></textarea>
    </div>

    <div>
        <label>Status do agendamento:</label>
        <select name="status" class="status" required>
            <option value="banho">Banho</option>
            <option value="retirar">Retirar</option>
            <option value="aguardando retirar">Aguardando</option>
            <option value="concluído">Concluído</option>
        </select>
    </div>
    <button type="submit">Salvar</button>
</form>

    </div>
</section>
</body>
</html>
