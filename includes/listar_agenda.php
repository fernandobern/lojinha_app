<?php
include '../includes/conexao.php';

// Consulta SQL ajustada para a view resumo_agendamentos
$sqlAgenda = "
    SELECT * FROM resumo_agendamentos
    WHERE 
    deleted_at IS NULL AND data >= CURDATE()
    ORDER BY 
    agendamento_id
";



// Executar a consulta
$result = $conn->query($sqlAgenda);

/* if ($result->num_rows > 0) {
    // Exibir os dados em uma tabela HTML
    echo "<table border='1'>
            <tr>
                <th>id</th>
                <th>cliente_nome</th>
                <th>pet_nome</th>
                <th>status</th>
                <th>servico_nome</th>
                <th>servico_preco</th>
                <th>servico_valor</th>
                <th>data1</th>
                <th>hora1</th>
                <th>data2</th>
                <th>hora2</th>
                <th>data3</th>
                <th>hora3</th>
                <th>data4</th>
                <th>hora4</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['agendamento_id']}</td>
                <td>{$row['cliente_nome']}</td>
                <td>{$row['pet_nome']}</td>
                <td>{$row['agendamento_status']}</td>
                <td>{$row['servico_nome']}</td>
                <td>{$row['servico_preco']}</td>
                <td>{$row['servico_valor']}</td>
                <td>{$row['data1']}</td>
                <td>{$row['hora1']}</td>
                <td>{$row['data2']}</td>
                <td>{$row['hora2']}</td>
                <td>{$row['data3']}</td>
                <td>{$row['hora3']}</td>
                <td>{$row['data4']}</td>
                <td>{$row['hora4']}</td>
            </tr>";
    }

    echo "</table>";
} else {
    echo "Nenhum resultado encontrado.";
} */

$conn->close(); 
?>
