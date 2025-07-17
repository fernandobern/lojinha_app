<?php
include '../includes/conexao.php';

$query = $_GET['search'] ?? '';

$sql = "SELECT id, name, tel, email, created_at FROM clientes WHERE (name LIKE '%$query%' or tel LIKE '%$query%') and deleted_at is null";

$result = $conn->query($sql);

$sqlEndereco = "SELECT bairro, endereco FROM enderecos WHERE bairro LIKE '%$query%' or endereco LIKE '%$query%'";
$resultEndereco = $conn->query($sqlEndereco);

$conn->close(); 
?>

