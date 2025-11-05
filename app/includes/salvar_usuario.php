<?php
include_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? null;
    $username = $_POST['username'] ?? null;
    $tel = $_POST['tel'] ?? null;
    $password = $_POST['password'] ?? null;
    $departamento_id = $_POST['departamento_id'] ?? null;
    $user_type = $_POST['user_type'] ?? null;

    if ($password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    $sql = "INSERT INTO usuarios (name, username, tel, password, departamento_id, user_type, created_at)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii", $name, $username, $tel, $password, $departamento_id, $user_type);

    if ($stmt->execute()) {
        header("Location: ../public/config/config.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
}
