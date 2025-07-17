<?php
include '../includes/conexao.php'; 

function getServices($conn) { // Passa a conexão como parâmetro
    $sql_services = "SELECT * FROM servicos";
    $stmt = $conn->prepare($sql_services);

    if (!$stmt) {
        die("Erro na preparação da consulta: " . $conn->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Chamando a função corretamente
//servicos = getServices($conn);

?>
