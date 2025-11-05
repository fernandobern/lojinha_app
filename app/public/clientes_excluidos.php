<?php include("../includes/listar_clientes_excluidos.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Clientes Excluídos</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body class="container">
<?php include('../templates/header.php'); ?>

<h1>Clientes Excluídos</h1>

<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Excluído em</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cliente = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $cliente['id'] ?></td>
                <td><?= $cliente['name'] ?></td>
                <td><?= $cliente['tel'] ?></td>
                <td><?= $cliente['email'] ?></td>
                <td><?= $cliente['deleted_at'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include('../templates/footer.php'); ?>
</body>
</html>
