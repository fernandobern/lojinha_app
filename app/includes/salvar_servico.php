<?php
include_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? null;
    $valor = $_POST['valor'] ?? null;
    $duracao = $_POST['duracao'] ?? null;

    $sql = "INSERT INTO servicos (descricao, valor, duracao) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sds", $descricao, $valor, $duracao);

    if ($stmt->execute()) {
        header("Location: ../public/config/config.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
}
