<?php
include("../includes/conexao.php");

// Quantos registros por página
$limite = 10;

// Página atual
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina < 1) $pagina = 1;

// Calcular o OFFSET
$offset = ($pagina - 1) * $limite;

// Se tiver busca
$search = isset($_GET['search']) ? $_GET['search'] : "";

if ($search != "") {
    $sql = "SELECT * FROM clientes 
            WHERE name LIKE '%$search%'  AND deleted_at IS NULL
            ORDER BY id DESC 
            LIMIT $limite OFFSET $offset";
    $sqlTotal = "SELECT COUNT(*) AS total FROM clientes 
                 WHERE name LIKE '%$search%' AND deleted_at IS NULL";
} else {
    $sql = "SELECT * FROM clientes WHERE deleted_at IS NULL 
            ORDER BY id DESC 
            LIMIT $limite OFFSET $offset ";
    $sqlTotal = "SELECT COUNT(*) AS total FROM clientes WHERE deleted_at IS NULL";
}

$result = $conn->query($sql);

// Total de registros para calcular páginas
$resTotal = $conn->query($sqlTotal);
$rowTotal = $resTotal->fetch_assoc();
$totalRegistros = $rowTotal['total'];
$totalPaginas = ceil($totalRegistros / $limite);
