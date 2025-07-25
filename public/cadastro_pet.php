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
            <h3>CADASTRANDO PARA: <strong><?php echo $name ?></strong></h3>
            <br>
            <p class="sub-title">CADASTRO DE PETS</p>
            <br>
            <div class="box">
                <h3>Pets cadastrados:</h3>
                <?php
                foreach ($petsCliente as $index => $pet) {
                    if ($pet === null || $pet === 'null' || empty($pet)) {
                        $petsCliente[$index] = 'não informado';
                    }
                    echo "<div class='pet-card'>";
                    echo "<h4>Nome: " . htmlspecialchars($pet['name']) . "</h4>";
                    echo "<p>Espécie: " . htmlspecialchars($pet['especie']) . "</p>";
                    echo "<p>Raça: " . htmlspecialchars($pet['raca']) . "</p>";
                    echo "<p>Sexo: " . htmlspecialchars($pet['sexo']) . "</p>";
                    echo "<p>Peso: " . htmlspecialchars($pet['peso']) . " kg</p>";
                    echo "<p>Nascimento: " . htmlspecialchars($pet['birth'] ?? 'Não informado') . "</p>";
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
            <label for="Sexo">Selecione a especie:</label>
            <select class="select_item" name="especie" id="">
                <optgroup label="Escolha um especie:">
                    <option value="Cachorro">Cachorro</option>
                    <option value="Gato">Gato</option>
                    <option value="Ramster">Ramster</option>
                    <option value="Coelho">Coelho</option>
                </optgroup>
            </select>
            <label for="Sexo">Sexo do animal:</label>
            <select class="select_item" name="sex" id="">
                <optgroup label="Sexo do animal:">
                    <option  value="M">Macho</option>
                    <option  value="F">Femea</option>
                </optgroup>
            </select>
            <input type="text" name="name_pet" placeholder="Nome">
            <input type="text" name="raca" placeholder="Raça">
            <div class="">
                <label for="">Data de nascimento(opcional)</label>
                <input type="date" name="birth" placeholder="birth">
                <?php $today = date("d.m.y");?>
                <input type="text" name="data_cadastro" placeholder="cadastro" value="<?php echo $today;?>" hidden>
            </div>
            <input type="text" name="peso" placeholder="Peso">
            <input type="number" name="idade" placeholder="idade">
            <input type="text" name="observacoes" placeholder="observacoes">
            
            <input type="hidden" name="cliente_id" value="<?php echo $id ?>">
            <button type="update" name="cadastrar_pet">Salvar Edição</button>
        </form>
    </main>

    <?php include '../templates/footer.php'; ?>

