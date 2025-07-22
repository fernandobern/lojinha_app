<?php
include_once('../includes/conexao.php');

if (isset($_POST['update'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id) {
        echo "ID inválido ou não fornecido.";
        exit();
    }

    $name = trim($_POST['name']);
    $tel = trim($_POST['tel']);
    $email = trim($_POST['email']);
    $cidade = trim($_POST['cidade']);
    $rua = trim($_POST['rua']);
    $bairro = trim($_POST['bairro']);
    $cep = trim($_POST['cep']);

    if (empty($name) || empty($tel) || empty($email)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit();
    }

    $stmtCliente = $conn->prepare("UPDATE clientes SET name = ?, tel = ?, email = ? WHERE id = ?");
    $stmtCliente->bind_param("sssi", $name, $tel, $email, $id);
    if (!$stmtCliente->execute()) {
        echo "Erro ao atualizar cliente: " . $stmtCliente->error;
        exit();
    }

    $stmtEndereco = $conn->prepare("UPDATE enderecos SET cidade = ?, rua = ?, bairro = ?, cep = ? WHERE cliente_id = ?");
    $stmtEndereco->bind_param("ssssi", $cidade, $endereco, $bairro, $cep, $id);
    if (!$stmtEndereco->execute()) {
        echo "Erro ao atualizar endereço: " . $stmtEndereco->error;
        exit();
    }

    $stmtCliente->close();
    $stmtEndereco->close();
    $conn->close();

    header('Location: ../public/clientes.php', true, 303);
    exit();
}
?>

