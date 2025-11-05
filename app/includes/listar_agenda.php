<?php
include '../includes/conexao.php';

// Definir quantidade de registros por página
$limite = 10;

// Página atual vinda da URL (ex: agenda.php?pagina=2)
$pagina = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;

// Calcular o OFFSET
$offset = ($pagina - 1) * $limite;

// Buscar total de registros para calcular o número de páginas
$totalQuery = $conn->query("
    SELECT COUNT(*) as total 
    FROM resumo_agendamentos
    WHERE data_cancelada IS NULL AND data >= CURDATE()
");
$total = $totalQuery->fetch_assoc()['total'];
$paginas = ceil($total / $limite);

// Consulta paginada
$sqlAgenda = "
    SELECT * 
    FROM resumo_agendamentos
    WHERE data_cancelada IS NULL AND data >= CURDATE()
    ORDER BY agendamento_id
    LIMIT $limite OFFSET $offset
";

// Executar a consulta
$result = $conn->query($sqlAgenda);

$conn->close();
?>
