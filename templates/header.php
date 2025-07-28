<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['user_type'])) {
    echo "Usuário inválido";
    exit();
}

$user_type = $_SESSION['user_type'];
$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lojinha Pet</title>
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/header.css">
</head>
<body>
    <div class="container">
        <img src="../images/logo.png" alt="Sua Logo" class="logo">
        <br>
        <header>
            <div>
                <a class="menu_button" href="../public/acompanhar_dia.php">
                    <img src="../images/banhoIcon.png" alt="Acompanhar banhos do dia">
                </a>
                <a class="menu_button" href="../public/cadastro_cliente.php">CADASTRO</a>
                <a class="menu_button" href="../public/agendamentos.php">AGENDA</a>
                <a class="menu_button" href="../public/clientes.php">CLIENTES</a>

                <?php if ($user_type != 0): ?>
                    <a class="menu_button" href="../public/relatorios.php">RELATÓRIOS</a>
                    <a class="menu_button" href="../public/config.php">CONFIGURAÇÃO</a>
                <?php endif; ?>

                <span class="bem-vindo">
                    Bem-vindo(a), <strong><?= $username ?>!</strong>
                    <a class="sair" style="color: #fff;" href="../includes/logout.php">sair</a>
                </span>
            </div>
        </header>
    </div>
</body>
</html>
