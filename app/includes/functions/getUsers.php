<?php
include_once __DIR__ . '/../conexao.php';

function getUsers($conn) {
    $sql = "SELECT id, username, tel, user_type FROM usuarios WHERE deleted_at IS NULL";
    $result = $conn->query($sql);

    $usuarios = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }
    return $usuarios;
}

// Executa automaticamente e deixa a variável disponível
$usuarios = getUsers($conn);
