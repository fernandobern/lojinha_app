<?php
include '../includes/conexao.php';

if (!isset($_GET['id'])) {
    die("Cliente não informado!");
}

$cliente_id = intval($_GET['id']);

// Buscar informações do cliente
$sqlCliente = "SELECT c.id, c.name, c.tel, c.email, e.rua, e.numero, e.bairro, e.cidade, e.estado
               FROM clientes c
               LEFT JOIN enderecos e ON e.cliente_id = c.id
               WHERE c.id = $cliente_id";
$resultCliente = $conn->query($sqlCliente);
$cliente = $resultCliente->fetch_assoc();

// Buscar pets do cliente
$sqlPets = "SELECT id, name, especie, raca, peso, observacoes FROM pets WHERE cliente_id = $cliente_id";
$resultPets = $conn->query($sqlPets);

// Buscar agendamentos do cliente
$sqlAgend = "SELECT a.id, a.created_at, a.valor_final, a.observacoes_cliente, a.observacoes_pos_banho
             FROM agendamentos a
             WHERE a.cliente_id = $cliente_id
             ORDER BY a.created_at DESC";
$resultAgend = $conn->query($sqlAgend);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Cliente</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/form.css">
    <link rel="stylesheet" href="../css/cliente_info.css">
    <style>
        h2 { margin-top: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .acoes button { margin-right: 5px; }
    </style>
</head>
<body>
    <div class="container">
    <?php
        include_once '../templates/header.php'
    ?>
    <div class="cliente_info">
        <h1>Cliente: <?php echo htmlspecialchars($cliente['name']); ?></h1>
        <div>
            
        </div>
        <p><strong>Telefone:</strong> <?= htmlspecialchars($cliente['tel']) ?></p>
        <p><strong>Email:</strong> <?php echo $cliente['email']; ?></p>
        <p><strong>Endereço:</strong> 
            <?php echo $cliente['rua']." ".$cliente['numero'].", ".$cliente['bairro']." - ".$cliente['cidade']."/".$cliente['estado']; ?>
        </p>
        
    <?php
    $telefone = preg_replace('/\D/', '', $cliente['tel']); // só números
    $mensagem = urlencode("Olá, tudo bem?"); // mensagem opcional
    ?>
    <a href="https://wa.me/55<?= $telefone ?>?text=<?= $mensagem ?>" target="_blank" style="
        display: inline-block;
        margin-top: 5px;
        padding: 8px 15px;
        background-color: #25D366;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
    ">WhatsApp</a>
    </div>

    <br>
    
    <table>
        <tr>
            <th>id</th>
            <th>Nome</th>
            <th>Espécie</th>
            <th>Raça</th>
            <th>Peso</th>
            <th>Observações</th>
            <th>...</th>
        </tr>
        <?php while($pet = $resultPets->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($pet['id']); ?></td>
            <td><?php echo htmlspecialchars($pet['name']); ?></td>
            <td><?php echo htmlspecialchars($pet['especie']); ?></td>
            <td><?php echo htmlspecialchars($pet['raca']); ?></td>
            <td><?php echo htmlspecialchars($pet['peso']); ?> kg</td>
            <td><?php echo htmlspecialchars($pet['observacoes']); ?></td>
            <td><a class='btn' href='cadastro_pet.php?id=<?php echo $pet['id']; ?>'>Editar Pet</a></td>
            
        </tr>
        <?php } ?>
    </table>

    <h2>Agendamentos</h2>
    <table>
        <tr>
            <th>Data</th>
            <th>Valor Final</th>
            <th>Observações cliente</th>
            <th>Ações</th>
        </tr>
        <?php while($ag = $resultAgend->fetch_assoc()) { ?>
        <tr>
            <td><?php echo date("d/m/Y H:i", strtotime($ag['created_at'])); ?></td>
            <td>R$ <?php echo number_format($ag['valor_final'] ?? "0", 2, ',', '.'); ?></td>
            <td><?php echo htmlspecialchars($ag['observacoes_cliente'] ?? "Não informado"); ?></td>
            <td class="acoes">
                <a href="comprovante.php?id=<?php echo $ag['id']; ?>"><button>Gerar Comprovante</button></a>
                <a href="editar_agendamento.php?id=<?php echo $ag['id']; ?>"><button>Editar</button></a>
            </td>
        </tr>
        <?php } ?>
    </table>

    </div>
</body>
</html>
