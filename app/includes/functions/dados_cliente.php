<?php
    include_once('../includes/conexao.php');
    $id_cliente = $_GET['id'];

    function getCliente($id_cliente, $conn) {
        $queryCliente = "SELECT * FROM clientes WHERE id = $id_cliente";
        $queryResult = $conn->query($queryCliente);
        return $queryResult->fetch_assoc();
    }

    $cliente = getCliente($id_cliente, $conn);

    if ($cliente == null) {
        echo 'Nenhum cliente encontrado com o ID informado!';
    } else {
        //print_r($cliente);
    }
?>