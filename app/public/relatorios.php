<?php
// Conexão
require_once("../includes/conexao.php");
//include '../includes/relatorio_dados.php'; 
// Exemplo de relatórios — você pode trocar pelas consultas reais
$relatorios = [];

// Total de clientes
$sql = "SELECT COUNT(*) AS total_clientes FROM clientes";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total de Clientes",
        "valor" => $row['total_clientes']
    ];
}

// Total de pets
$sql = "SELECT COUNT(*) AS total_pets FROM pets";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total de Pets",
        "valor" => $row['total_pets']
    ];
}

// Total de serviços cadastrados
$sql = "SELECT COUNT(*) AS total_servicos FROM servicos";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Serviços Cadastrados",
        "valor" => $row['total_servicos']
    ];
}

// Total de agendamentos
$sql = "SELECT COUNT(*) AS total_agendamentos FROM agendamentos";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total Agendamentos",
        "valor" => $row['total_agendamentos']
    ];
}

include '../includes/relatorios/mensal/agendamentos.php';
include '../includes/relatorios/mensal/lucro_mensal.php';

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <link rel="stylesheet" href="../css/relatorios.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <style>
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 1.5rem;
            width: 250px;
            height: fit-content;
            text-align: center;
        }
        .card h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }
        .card p {
            font-size: 2rem;
            font-weight: bold;
            margin: 0.5rem 0 0;
            color: #0077cc;
        }
    </style>
</head>
<body>

<?php include ('../templates/header.php'); ?>
<div class="container main">
    <!-- relatórios padrão / gerais -->
    <div class="card_session">
        <?php foreach ($relatorios as $r): ?>
        <div class="card">
            <h3><?= htmlspecialchars($r['titulo']) ?></h3>
            <p><?= htmlspecialchars($r['valor']) ?></p>
        </div> <br>
        <?php endforeach; ?>
        <br>
    </div>

    <div class="card">
        <h3>Solicitar relatório</h3>
        <br>
        <form action="" method="post">
            <label for="">Descreva o relatório desejado abaixo</label>
            <textarea class="text_send" type="text" name="" id=""></textarea><br>
            <input class="btn" type="submit" value="Solicitar">
        </form>
    </div>  
</div>
</body>
</html>
