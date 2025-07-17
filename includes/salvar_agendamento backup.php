<?php
include '../includes/conexao.php'; // Inclui a conexão com o banco
include '../public/cadastrar_agendamento.php';

// Obtém o ID do cliente passado via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    echo "ID do cliente não fornecido.";
    exit();
}

if (isset($_POST['submit'])) {
    // Recupera os dados do formulário
    $cliente_id = $id;
    $pacote = $_POST['pacote'];
    $data_01 = $_POST['data_01'];
    $data_02 = $_POST['data_02'];
    $data_03 = $_POST['data_03'];
    $data_04 = $_POST['data_04'];
    $obs_cliente = $_POST['obs_cliente'];
    $pet_id = $_POST['pet_id'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $endereco = $_POST['endereco'];
    $cep = $_POST['cep'];
    $status = $_POST['status'];

    // Verifica se um ou mais serviços foram selecionados
    if (!empty($_POST['services_selected'])) {
        $services_selected = $_POST['services_selected'];
    } else {
        echo "Nenhum serviço selecionado.";
        exit();
    }

    // Insere o agendamento no banco de dados
    $sql_agendamento = "INSERT INTO agendamentos (cliente_id, pet_id, pacote, obs_cliente, status) 
                        VALUES ('$id', '$pet_id', '$pacote', '$obs_cliente', '$status')";

    if ($conn->query($sql_agendamento) === TRUE) {
        $agendamento_id = $conn->insert_id; // Recupera o último ID inserido

        // Insere os serviços no banco de dados
        foreach ($services_selected as $servico_id) {
            $sql_servico = "INSERT INTO agendamento_servico (agendamento_id, servico_id) VALUES ('$agendamento_id', '$servico_id')";
            if (!$conn->query($sql_servico)) {
                echo "Serviço: salvo com sucesso " . $conn->error;
                exit();
            }
        }

        // Insere as datas na tabela agendamento_datas
        $datas = [$data_01, $data_02, $data_03, $data_04];
        foreach ($datas as $data) {
            if (!empty($data)) {
                $sql_data = "INSERT INTO agendamento_datas (agendamento_id, data) VALUES ('$agendamento_id', '$data')";
                if (!$conn->query($sql_data)) {
                    echo "Erro ao cadastrar data: " . $conn->error;
                    exit();
                }
            }
        }

        // Insere o endereço no banco de dados
        $sql_endereco = "INSERT INTO enderecos (cliente_id, cidade, bairro, endereco, cep) 
                         VALUES ('$cliente_id', '$cidade', '$bairro', '$endereco', '$cep')";
        if ($conn->query($sql_endereco) === TRUE) {
            echo "Endereço salvo com sucesso!";
            header('Location: ../public/clientes.php');
            exit();
        } else {
            echo "Erro ao salvar endereço: " . $conn->error;
            exit();
        }
    } else {
        echo "Erro ao cadastrar agendamento: " . $conn->error;
        exit();
    }
}

$conn->close();
?>
