<?php
include 'conexao.php';

$sql = "SELECT * FROM clientes WHERE deleted_at IS NOT NULL ORDER BY deleted_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>
