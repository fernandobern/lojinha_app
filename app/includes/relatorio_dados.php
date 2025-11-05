<?php
include 'conexao.php';

header('Content-Type: application/json');

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
        "titulo" => "Total de Agendamentos",
        "valor" => $row['total_agendamentos']
    ];
}

// Total de agendamentos
$sql = "SELECT COUNT(*) AS total_agendamentos FROM agendamentos";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total de Agendamentos",
        "valor" => $row['total_agendamentos']
    ];
}

// Total de agendamentos
$data_atual = new DateTime();
$data_mysql = $data_atual->format('Y-m-d H:i:s');

$sql = "SELECT COUNT(*) AS total_agendamentos_mes FROM agendamentos WHERE created_at = '$data_mysql'";
$result = $conn->query($sql);
if ($result && $row = $result->fetch_assoc()) {
    $relatorios[] = [
        "titulo" => "Total de Agendamentos Mes",
        "valor" => $row['total_agendamentos_mes']
    ];
}
    

?>
