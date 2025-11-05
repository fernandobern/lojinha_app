<?php
include '../templates/header.php';
//include '../includes/conexao.php'; // Inclui a conexão com o banco
include '../includes/functions/dados_cliente.php';
include '../includes/functions/endereco_cliente.php';

// Buscar endereço do cliente (usando função externa)
$endereco = getEndereco($cliente_id, $conn);

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
    <br>
    <br>
<section class="container">
    <div class="">
        <!-- Exibe o nome do cliente ou uma mensagem de erro -->
        <?php if ($cliente): ?>
            <span style="color: white;">Você está agendando para:
                <h3><?php echo htmlspecialchars($cliente['name']); ?></h3>
                <br>
                Com o telefone:
                <h3><?php echo htmlspecialchars($cliente['tel']); ?></h3>
                <br>
                Retirada e Entrega:
                <h3><?php  
                if ($endereco === null) {
                    echo "Enderenço não cadastrado.";
                } else {
                    echo "Bairro: " .htmlspecialchars($endereco['bairro']."");
                } ?></h3>
                <h3><?php  
                if ($endereco === null) {
                    echo "Enderenço não cadastrado.";
                } else {
                    echo "Rua: " .htmlspecialchars($endereco['rua']."");
                } ?></h3>
            </span>
        <?php else: ?>
            <h2><?php echo 'No momento não existe cliente selecionado!'; ?></h2>
        <?php endif; ?>

        <form class="form-box" action="../includes/criar_agendamento.php?id=<?php echo isset($id_cliente) ? $id_cliente : ''; ?>" method="POST">
            <!-- Campos ocultos para enviar os dados do cliente -->
            <input type="hidden" name="id_cliente" value="<?php echo $cliente['id']; ?>" required>
            <input type="hidden" name="name" value="<?php echo $cliente['name']; ?>" required>
            <input type="hidden" name="tel" value="<?php echo $cliente['tel']; ?>" required>
            <button type="submit" name="submit">CRIAR AGENDAMENTO</button>
        </form>
    </div>
</section>
</body>
</html>
