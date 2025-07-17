<?php
function getPets($id_agendamento, $conn) {
    // Consulta para obter dados dos pets do cliente
    $sql_pets = "
    SELECT P.* 
    FROM pets P 
    JOIN agendamentos A ON A.cliente_id = P.cliente_id
    WHERE A.id = ? and p.deleted_at is null";
    
    $stmt = $conn->prepare($sql_pets);
    $stmt->bind_param("i", $id_agendamento);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_all(MYSQLI_ASSOC);
}

?>