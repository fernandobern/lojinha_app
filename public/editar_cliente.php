<?php
include ('../includes/edit_client.php');
include ('../includes/save_edit_cliente.php');
include_once ('../includes/functions/endereco_cliente.php');

// Buscar endereço do cliente (usando função externa)
$endereco = getEndereco($cliente_id, $conn);
var_dump($endereco);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Clientes e Agendamento</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body class="container">

<?php include ('../templates/header_pdv.php'); ?>
    <main class="form-box">
        <form id="cliente-form" action="../includes/save_edit_cliente.php" method="post">
            <p class="sub-title">Edição de cliente:</p>
            <br>
            <input type="text" name="name" placeholder="Nome do Cliente" value="<?php echo $name ?>">
            <input type="number" name="tel" placeholder="Contato" value="<?php echo $tel ?>">
            <input type="text" name="email" placeholder="E-mail" value="<?php echo $email ?>">
            <p class="mini-title">Endereço de Retirada e Entrega:</p>
            <br>
            <input type="text" name="cidade" placeholder="Cidade" value="<?php echo $endereco['cidade'] ?>">
            <input type="text" name="bairro" placeholder="Bairro" value="<?php echo $endereco['bairro']  ?>">
            <input type="text" name="rua" placeholder="Rua" value="<?php echo $endereco['rua'] ?>">
            <input type="number" name="cep" placeholder="Cep" value="<?php echo $endereco['cep']  ?>">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button type="update" name="update">Salvar Edição</button>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

