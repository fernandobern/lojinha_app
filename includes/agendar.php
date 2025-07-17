<?php

if (!empty($_GET['id'])) {
    // Incluir arquivo de conexão com o banco de dados
    include ('../includes/conexao.php');

    // Pegando o ID da URL via GET
    $id = $_GET['id'];

    // Usar Prepared Statement para evitar injeção de SQL
    $sqlSelectQuery = "SELECT * FROM clientes WHERE id = $id";
    $result = $conn->query($sqlSelectQuery);
        // Verificar se o cliente foi encontrado
        if ($result->num_rows > 0) {
            while ($client_data = mysqli_fetch_assoc($result)) {
            // Obter os dados do cliente
            $name = $client_data['name'];
            $tel = $client_data['tel'];
            $email = $client_data['email'];

            $sqlUpdate = ("UPDATE nome='$name',tel='$tel',email='$email' WHERE id='$id'");
            }

        } else {
            header('Location: ../public/clientes.php');
        }

        $sql_endereco = "SELECT * FROM enderecos WHERE cliente_id = $id";;
        $result_endereco = $conn->query($sql_endereco);
            if ($result->num_rows > 0) {
                while ($endereco_client_data = mysqli_fetch_assoc($result_endereco)) {
                    $cidade = $endereco_client_data['cidade'];
                    $endereco = $endereco_client_data['endereco'];
                    $bairro = $endereco_client_data['bairro'];
                    $cep = $endereco_client_data['cep'];
                    $id_cliente = $id;

                    $sqlUpdate = ("UPDATE endereco='$endereco',bairro='$bairro',cep='$cep' WHERE id='$id'");
                }
            } else {
                header('Location: ../public/clientes.php');
            }
        }
    // Redirecionar se o ID não for fornecido


?>
