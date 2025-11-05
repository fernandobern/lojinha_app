<?php
//conectar
include('../conexao.php');

//pegar o id a ser alterado
$data_id = $_GET['data_id'] ?? null;

if (empty($data_id)) {
    echo "Agendamento não encontrado.";
    exit;
} else {
    $query = $conn->prepare("
        UPDATE agendamento_datas SET status = 'concluido' WHERE id = ?
    ");
    $query->bind_param("i", $data_id);
        if ($query->execute()) {
            header('Location: ../../public/agendamentos.php');
            exit;
        } else {
            echo "Erro ao concluir agendamento.";
    }
}

?>