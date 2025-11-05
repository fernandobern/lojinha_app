<?php
include_once '../conexao.php'; // ajusta se o caminho for diferente

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // segurança básica, força ser número

    // SQL para deletar
    $sql = "DELETE FROM servicos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // volta para a página de config depois de excluir
        header("Location: ../../public/config/config.php");
        exit;
    } else {
        echo "Erro ao deletar: " . $conn->error;
    }
} else {
    echo "ID inválido.";
}
