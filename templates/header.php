<?php
// Verificar se o usuário está logado
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
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
                <a class="menu_button" href="../public/acompanhar_dia.php"><img src="../images/banhoIcon.png" alt="Acompanhar banhos do dia"></a>
                <a class="menu_button" href="../public/cadastro_cliente.php">CADASTRO</a>
                <a class="menu_button" href="../public/agendamentos.php">AGENDA</a>
                <a class="menu_button" href="../public/clientes.php">CLIENTES</a>
                <a class="menu_button" href="../public/relatorios.php">RELATÓRIOS</a>
                <a class="menu_button" href="../public/config.php">CONFIGURAÇÃO</a>
                <a class="bem-vindo" href="">Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['username']); ?>!<a class="sair"style="color: #ffff;" href="../includes/logout.php">sair</a></a>
            </div>
        </header>
    </div>
<!--     <div class="bem-vindo">
        <span class="mini-title">Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <p><a style="color: #ffff;" href="../includes/logout.php">sair</a></p>
    </div> -->
</body>
</html>
