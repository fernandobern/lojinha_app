<?php
include ('../includes/edit_client.php');
include ('../includes/save_edit_cliente.php');
include ('../includes/functions/getPet.php');
//include ('../includes/functions/excluirPet.php');

// Buscar endereço do cliente (usando função externa)
$endereco = getEndereco($cliente_id, $conn);
$cliente = $endereco['cliente_id'];
$petsCliente = getPets($cliente, $conn);
//Buscar pets
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Pets</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body class="container">

<?php include ('../templates/header_pdv.php'); ?>
    <main class="form-box">
        <form id="cliente-form" action="../includes/cadastrar_pet.php" method="post">
            <p class="sub-title">CADASTRO DE PETS</p>
            <br>
            <span>CADASTRANDO PARA: <strong><?php echo $name ?></strong></span>
            <div class="box">
                <h3>Pets cadastrados:</h3>
                <?php
                foreach ($petsCliente as $pet) {
                    echo "<div class='pet-card'>";
                    echo "<h4>Nome: " . htmlspecialchars($pet['name_pet']) . "</h4>";
                    echo "<p>Espécie: " . htmlspecialchars($pet['especie']) . "</p>";
                    echo "<p>Raça: " . htmlspecialchars($pet['raca']) . "</p>";
                    echo "<p>Sexo: " . htmlspecialchars($pet['sexo']) . "</p>";
                    echo "<p>Peso: " . htmlspecialchars($pet['peso']) . " kg</p>";
                    echo "<p>Nascimento: " . htmlspecialchars($pet['birth']) . "</p>";
                    echo "<p>Observações: " . htmlspecialchars($pet['observacoes']) . "</p>";
                    echo "<p>Cadastrado em: " . htmlspecialchars($pet['created_at']) . "</p>";
                    echo "<a class='btn' href='../includes/functions/excluirPet.php?id=" . $pet['id'] . "'>Excluir</a>";
                    echo "</div>";
                }
                ?>
            </div>
                        
            <br>
            <br>
            <p class="mini-title">Insira os dados do Pet:</p>
            <br>
            <select class="select_item" name="especie" id="">
                <optgroup label="Escolha um especie:">
                    <option value="Cachorro">Cachorro</option>
                    <option value="Gato">Gato</option>
                    <option value="Ramster">Ramster</option>
                    <option value="Coelho">Coelho</option>
                </optgroup>
            </select>
            <input type="text" name="name_pet" placeholder="Nome">
            <input type="text" name="raca" placeholder="Raça">
            <input type="text" name="sex" placeholder="Sexo">
            <input type="date" name="birth" placeholder="birth">
            <input type="text" name="peso" placeholder="Peso">
            <input type="number" name="idade" placeholder="idade">
            <input type="text" name="observacoes" placeholder="observacoes">
            <input type="hidden" name="cliente_id" value="<?php echo $id ?>">
            <button type="update" name="cadastrar_pet">Salvar Edição</button>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

