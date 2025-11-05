<?php
include_once '../conexao.php'; // Ajuste o caminho se necessário

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // segurança básica

    // Data atual no formato padrão SQL
    $dataAtual = date('Y-m-d H:i:s');

    // Atualiza apenas a coluna deleted_at
    $sql = "UPDATE usuarios SET deleted_at = '$dataAtual' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../../public/config/config.php");
        exit;
    } else {
        echo "Erro ao marcar usuário como deletado: " . $conn->error;
    }
} else {
    echo "ID inválido.";
}
