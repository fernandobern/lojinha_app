<?php

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
        <form id="cliente-form" action="../includes/cadastro_cliente.php" method="post">
            <p class="sub-title">Cadastro de clientes:</p>
            <br>
            <input type="text" name="name" placeholder="Nome do Cliente" required>
            <input type="number" name="tel" placeholder="Contato" required>
            <input type="text" name="email" placeholder="E-mail">
            <p class="mini-title">Endereço de Retirada e Entrega:</p>
            <br>
            <input type="text" name="cidade" placeholder="Cidade" required>
            <input type="text" name="bairro" placeholder="Bairro" required>
            <input type="text" name="endereco" placeholder="Endereço" required>
            <input type="number" name="cep" placeholder="Cep" required>
            <button type="submit">Cadastrar</button>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>
</body>
</html>
