<?php
    include("../includes/listar_clientes.php");
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

<?php include ('../templates/header.php'); ?>
<?php include ('../includes/listar_clientes.php'); ?>
<main class="form-box">
    <div>

    <h1>Busca de Clientes</h1>
    <br>
        <input type="search" name="search" id="pesquisar" placeholder="Digite o nome do cliente">
        <button onclick = "searchData()" type="submit">Buscar</button>
        <br>
        <br>
                <div class="topbar">
            <p>Ver excluídos</p>
            <a href="clientes_excluidos.php" class="btn-trash" title="Clientes Excluídos">🗑️</a>
        </div>
        <br>
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
                            <a class='btn' href='cliente_info.php?id=$client_data[id]'>Perfil</a>
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
    <div class="paginacao">
        <?php if ($pagina > 1): ?>
            <a href="?pagina=<?php echo $pagina - 1; ?>&search=<?php echo $search; ?>">&laquo; Anterior</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
            <?php if ($i == $pagina): ?>
                <strong><?php echo $i; ?></strong>
            <?php else: ?>
                <a href="?pagina=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($pagina < $totalPaginas): ?>
            <a href="?pagina=<?php echo $pagina + 1; ?>&search=<?php echo $search; ?>">Próxima &raquo;</a>
        <?php endif; ?>
    </div>

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
