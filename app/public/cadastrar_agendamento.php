<?php
include '../includes/conexao.php';

// Verifica se o ID foi passado e busca informações de cliente e pets
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtém o ID do cliente passado via GET

    // Consulta para obter dados do cliente
    $sql_cliente = "SELECT id, name, tel, email, created_at FROM clientes WHERE id = $id";
    $result_cliente = $conn->query($sql_cliente);

    // Consulta para obter dados dos pets do cliente
    $sql_pets = "SELECT * FROM pets WHERE cliente_id = $id";
    $result_pets = $conn->query($sql_pets);

    // Consulta para obter dados dos pets do cliente
    $sql_endereco = "SELECT * FROM enderecos WHERE cliente_id = $id";
    $result_endereco = $conn->query($sql_endereco);

    // Consulta para obter os serviços disponíveis
    $sql_services = "SELECT * FROM servicos";
    $result_services = $conn->query($sql_services);
    
    if ($result_cliente->num_rows > 0) {
        $cliente_data = $result_cliente->fetch_assoc(); // Obtém os dados do cliente
    } else {
        echo "Cliente não encontrado.";
        exit;
    }

    if ($result_endereco->num_rows > 0) {
        $endereco_data = $result_endereco->fetch_assoc();
    } else {
        echo "Sem endereço cadastrado";
        exit;
    }

    if ($result_services->num_rows > 0) {
        $service_data = $result_services->fetch_assoc(); // Obtém os servicos disponíveis
    } else {
        echo "Nenhum serviço encontrado.";
        exit;
    }

    } else {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];} // Obtém o ID do cliente passado via GET
        exit;
    }

$conn->close(); // Fecha a conexão
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Clientes</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body class="container">

    <?php include ('../templates/header_pdv.php'); ?>

    <main class="form-box">
        <form id="cliente-form" action="../includes/salvar_agendamento.php" method="POST">
            <p class="sub-title">Insira os dados para Agendar:</p>
            <br>
            <!-- Preenche o nome do cliente recuperado do banco -->
            <input type="text" name="cliente_id" placeholder="Nome do Cliente" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Nome do Cliente" value="<?php echo $cliente_data['name']; ?>">
            <input type="number" name="tel" placeholder="Contato" value="<?php echo $cliente_data['tel']; ?>">
            <p class="mini-title">Endereço de Retirada e Entrega:</p>
            <br>
            <!-- Formulário de endereço -->
            <input type="text" name="cidade" placeholder="Cidade" value="<?php echo $endereco_data['cidade']; ?>"required>
            <input type="text" name="bairro" placeholder="Bairro" value="<?php echo $endereco_data['bairro']; ?>" required>
            <input type="text" name="endereco" placeholder="Endereço" value="<?php echo $endereco_data['endereco']; ?>" required>
            <input type="number" name="cep" value="<?php echo $endereco_data['cep']; ?>" placeholder="CEP">
            <br>

            <!-- Exibe os pets associados ao cliente -->
            <span class="mini-title">Pets:</span>
            <?php
            if ($result_pets->num_rows > 0) {
                while ($pet_data = mysqli_fetch_assoc($result_pets)) {
                    echo "<div class='select_item'><br>";
                    echo "<input type='radio' name='pet_id' value='".$pet_data['id']."'> ".$pet_data['name_pet']."<br>"; 
                    echo "<button>
                            <a class='btn' href='excluir_pet.php?id=".$pet_data['id']."'>Excluir</a>
                          </button>";
                    echo "</div>";      
                }
            } else {
                echo "Nenhum pet encontrado.";
            }
            ?>
            <!-- Exibe os pacotes disponíveis -->
            <select name="pacote" class="pacotes" required>
                <option value="avulso">Avulso</option>
                <option value="mensal">Mensal</option>
                <option value="quinzenal">Quinzenal</option>
                <option value="semanal">Semanal</option>
            </select>

            <!-- Datas -->
            <input type="datetime-local" name="data_01">
            <input type="datetime-local" name="data_02">
            <input type="datetime-local" name="data_03">
            <input type="datetime-local" name="data_04">

            <!-- OBS cliente -->
            <input type="text" name="obs_cliente" placeholder="Observação">


            <!-- Exibe os serviços disponíveis -->
            <p class="mini-title">Serviços:</p><br>
            <?php
            if ($result_services->num_rows > 0) {
                while ($service_data = mysqli_fetch_assoc($result_services)) {
                    echo "<div class='select_item'>";
                    echo "<input type='checkbox' name='services_selected[]' value='".$service_data['id']."'>"; // Array para múltiplos serviços
                    echo "<label for='service_selected'>".$service_data['descricao']."</label><br>";
                    echo "<span class='valor'>R$".$service_data['valor']."</span>"; 
                    echo "<span>Prazo: ".$service_data['duracao']." minutos</span><br>";
                    echo "</div>";
                }
            } else {
                echo "Nenhum pet encontrado.";
            }
            
            ?>


            <button type="submit" name="submit">Cadastrar</button>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

</body>
</html>
