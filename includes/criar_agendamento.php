<?php
include ('../includes/conexao.php');
include ('../includes/functions/endereco_cliente.php');

//$endereco = $endereco['id'];

if (isset($_POST['submit'])) {
    $cliente_id = $_GET['id'];
    $endereco_id = getEndereco($cliente_id, $conn);

    // Criar um agendamento apenas com cliente_id e endereço
    $sql = "INSERT INTO agendamentos (cliente_id, endereco_id, status) VALUES (?, ?, 'pendente')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $cliente_id, $endereco_id);
    $stmt->execute();

    $id_agendamento = $stmt->insert_id; // Pegando o ID gerado

    // Redirecionar para a tela de edição do agendamentom do ceu
    header("Location: ../public/concluir_agendamento.php?id=$id_agendamento");
    exit();
}
?>
