<?php
function getPets($id_cliente, $conn) {
    // Consulta para obter dados dos pets do cliente
    $sql_pets = "
    SELECT * 
    FROM pets P 
    WHERE cliente_id = ? AND deleted_at IS NULL";
    
    $stmt = $conn->prepare($sql_pets);
    $stmt->bind_param("i", $id_cliente);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
    //return $result;
}
?>