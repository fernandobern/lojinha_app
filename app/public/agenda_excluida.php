<?php include("../includes/listar_agenda_excluida.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agendamentos Excluídos</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body class="container">
<?php include('../templates/header.php'); ?>

<h1>Agendamentos Excluídos</h1>

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Pet</th>
            <th>Serviço</th>
            <th>Data</th>
            <th>Cancelado em</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($a = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $a['agendamento_id'] ?></td>
                <td><?= $a['nome_cliente'] ?></td>
                <td><?= $a['nome_pet'] ?></td>
                <td><?= $a['servicos'] ?></td>
                <td><?= $a['data'] ?></td>
                <td><?= $a['data_cancelada'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include('../templates/footer.php'); ?>
</body>
</html>
