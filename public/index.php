<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div>
        <?php include ('../templates/header.php'); ?>
        <h1>Bem-vindo(a), <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p><a href="../includes/logout.php">sair</a></p>
        <?php include '../templates/footer.php'; ?>
    </div>

</body>
</html>
