<?php
    include("../includes/listar_clientes.php");
/* 

        if (!empty($_GET['search'])) {
        $data = $_GET['search'];
        echo ". $data .";
        echo "<br>";
        echo "Trazer todos os registros!";
    } else {
        $sql = "SELECT * FROM clientes --WHERE id LIKE '%$data%' or tel LIKE '%$data%' or name LIKE '%$data%' ORDER BY id DESC";
    }

    $result = $conn->query($sql); */
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Clientes</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
</head>
<body class="container">

<?php include ('../templates/header_pdv.php'); ?>
<?php include ('../includes/listar_clientes.php'); ?>
<main class="form-box">
    <div>
    <h1>Busca de Clientes</h1>
        <input type="search" name="search" id="pesquisar" placeholder="Digite o nome do cliente">
        <button onclick = "searchData()" type="submit">Buscar</button>
    </div>
</main>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Cadastro</th>
                <th>...</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while ($client_data = mysqli_fetch_assoc($result)) {
                    echo"<tr>";
                    echo "<td>".$client_data['id']."</td>";
                    echo "<td>".$client_data['name']."</td>";
                    echo "<td>".$client_data['tel']."</td>";
                    echo "<td>".$client_data['email']."</td>";
                    echo "<td>".$client_data['created_at']."</td>";
                    echo "<td>
                    <div>
                            <a class='btn' href='editar_cliente.php?id=$client_data[id]'>Editar</a>
                            <a class='btn' href='criar_agendamento.php?id=$client_data[id]'>Agendar</a>
                            <a class='btn' href='cadastro_pet.php?id=$client_data[id]'>Pets</a>
                            <a class='btn btn_red' href='../includes/functions/deleteCliente.php?id=" . $client_data['id'] . "'>Excluir</a>
                         </td></div>";
                }
            ?>
            <!-- Os dados serão inseridos aqui -->
        </tbody>
    </table>
</div>

<?php include '../templates/footer.php'; ?>

<script>
    var search = document.getElementById('pesquisar');

    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });
    function searchData() {
        window.location = 'clientes.php?search=' + search.value;
    }
</script>

</body>
</html>
