<?php
// Incluir arquivo de conexão com o banco de dados
include ('../includes/conexao.php');

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variáveis que armazenam os dados do Form
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $bairro = $_POST['bairro'];
    $cep = $_POST['cep'];
    $data_cadastro = date("Y-m-d H:i:s");

    // Preparar insert SQL para inserir os dados na tabela 'clientes'
    $sql_cliente = "INSERT INTO clientes (name, tel, email, created_at) VALUES (?, ?, ?, ?)";

    // Preparar declaração para a tabela 'clientes'
    if ($stmt_cliente = $conn->prepare($sql_cliente)) {
        // Bind dos parâmetros e execução da consulta para 'clientes'
        $stmt_cliente->bind_param("ssss", $name, $tel, $email, $data_cadastro);

        if ($stmt_cliente->execute()) {
            // Obter o último ID inserido
            $cliente_id = $stmt_cliente->insert_id;

            // Preparar insert SQL para inserir os dados na tabela 'enderecos'
            $sql_endereco = "INSERT INTO enderecos (endereco, bairro, cep, cliente_id) VALUES (?, ?, ?, ?)";

            if ($stmt_endereco = $conn->prepare($sql_endereco)) {
                // Bind dos parâmetros e execução da consulta para 'enderecos'
                $stmt_endereco->bind_param("sssi", $endereco, $bairro, $cep, $cliente_id);

                if ($stmt_endereco->execute()) {
                    header('Location: ../public/clientes.php');
                    echo "Dados inseridos com sucesso!";
                } else {
                    echo "Erro ao inserir os dados de endereço: " . $stmt_endereco->error;
                }

                // Fechar declaração do stmt_endereco
                $stmt_endereco->close();
            } else {
                echo "Erro na preparação da consulta de endereço: " . $conn->error;
            }
        } else {
            echo "Erro ao inserir os dados de cliente: " . $stmt_cliente->error;
        }

        // Fechar declaração do stmt_cliente
        $stmt_cliente->close();
    } else {
        echo "Erro na preparação da consulta de cliente: " . $conn->error;
    }
} else {
    // Se o formulário não for enviado corretamente
    echo "Erro: O formulário não foi submetido corretamente.";
}

// Fechar conexão
$conn->close();
?>
