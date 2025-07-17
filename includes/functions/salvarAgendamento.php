<?php
/*//CONCLUIR AGENDAMENTO
Agora vamos salvar e criar o agendamento, já tenho a função para pegar as
informações de endereço e cliente, ou seja, já tenho estes dados.
Agora preciso pegar os dados do cliente e inserir na tabela de agendamentos, e assim
criar o agendamento dele gerando um ID, após isso eu posso incluir mais informações 
no agendamento.

O agendamento já está criado (criar_agendamento.php), agora preciso incluir o restante 
das informações na tabela de agendamentos.
O que já tem ?
cliente_id, endereco_id, user_id(falta incluir, mas farei depois)
E o que será incluido agora ?
pet_id (já está sendo retornado dentro do form)
pacote
servicos (salvar na tabela agendamento_servico)
status (pendente - será o padrão por enquanto)
obs_cliente -> obs_final será utilizada em outra parte do processo junto ao end_at
valor_final
*/
//include '../conexao.php';
include '../dataCenter/DatabaseHelper.php';
//include './endereco_cliente.php';

//$endereco_cliente = getEndereco($cliente_id, $conn);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    function limpar($valor) {
        return htmlspecialchars(trim($valor));
    }

    // Recebendo e limpando os dados
    //$cliente = isset($_POST['id']) ? limpar($_POST['id']) : null;
    $cliente_id = isset($_POST['cliente_id']) ? limpar($_POST['cliente_id']) : null;;
    $endereco_id = isset($_POST['endereco_id']) ? limpar($_POST['pet_id']) : null;;
    $pet_id = isset($_POST['pet_id']) ? limpar($_POST['pet_id']) : null;
    $pacote = isset($_POST['pacote']) ? limpar($_POST['pacote']) : null;
    $obs_cliente = limpar($_POST['obs_cliente'] ?? '');
    $status_banho = limpar($_POST['status_banho'] ?? 'pendente');

    $agendamento_service_status = limpar($_POST['agendamento_service_status'] ?? 'aguardando');

    // Coletar datas e horas com validação
    $data = $_POST['data'] ?? null;
    $hora = $_POST['hora'] ?? null;
 
    $data1 = $_POST['data1'] ?? null;
    $hora1 = $_POST['hora1'] ?? null;
    $data2 = $_POST['data2'] ?? null;
    $hora2 = $_POST['hora2'] ?? null;
    $data3 = $_POST['data3'] ?? null;
    $hora3 = $_POST['hora3'] ?? null;
    $data4 = $_POST['data4'] ?? null;
    $hora4 = $_POST['hora4'] ?? null; 

    // Verificação básica para evitar inserir campos todos vazios
    $temData = $data1 || $data2 || $data3 || $data4;

    $servicos = $_POST['servico'] ?? [];

    // Mostrar os dados recebidos
    echo "<pre>";
    echo "Pet ID: "; var_dump($pet_id);
    echo "Cliente ID: "; var_dump($cliente_id);
    echo "Endereço ID: "; var_dump($endereco_id);
    echo "Pacote: "; var_dump($pacote);
    echo "Observações: "; var_dump($obs_cliente);
    echo "Datas e Horas: "; print_r($temData); echo"<br><br>";
    echo "Serviços: "; print_r($servicos);
    echo "</pre>";

    if (!$pet_id || empty($pacote)) {
        echo "Erro: Pet e pacote são obrigatórios.";
        exit;
    }

    try {
        // Inserir na tabela agendamentos
        $query = "INSERT INTO agendamentos (cliente_id, pet_id, endereco_id, pacote, obs_cliente, status) VALUES (?, ?, ?, ?, ?, ?)";
        $queryExec = $conn->prepare($query);
        $queryExec->bind_param("iiisss", $cliente_id, $pet_id, $endereco_id, $pacote, $obs_cliente, $status);
        $queryExec->execute();
        $id_agendamento = $conn->insert_id;
        echo "<p>ID agendamento: $id_agendamento</p>";

        // Inserir cada data/hora como uma linha separada
        $datas = $_POST['datas'] ?? [];

        $query = "INSERT INTO agendamento_datas (agendamento_id, data, hora, status) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        $linhaInserida = false;

        foreach ($datas as $item) {
            $data = $item['data'] ?? null;
            $hora = $item['hora'] ?? null;
            $status_banho = $item['status_banho'] ?? 'pendente';

            if (!empty($data) && $data !== '0000-00-00') {
                $stmt->bind_param("isss", $id_agendamento, $data, $hora, $status_banho);
                $stmt->execute();
                $linhaInserida = true;
            }
        }

        if ($linhaInserida) {
            echo "<p>Datas inseridas com sucesso.</p>";
        } else {
            echo "<p>Nenhuma data válida foi enviada.</p>";
        }

        // Inserir serviços
        if (!empty($servicos)) {
            $query = "INSERT INTO agendamento_servicos (agendamento_id, servico_id) VALUES (?, ?)";
            $queryExec = $conn->prepare($query);
            foreach ($servicos as $servico_id) {
                $servico_id = (int)$servico_id;
                $queryExec->bind_param("ii", $id_agendamento, $servico_id);
                $queryExec->execute();
            }
        }

        echo "<p>Agendamento salvo com sucesso!</p>";
        header('Location: ../../public/agendamentos.php');

    } catch (Exception $e) {
        echo "Erro ao salvar: " . $e->getMessage();
    }

    $conn->close();
    
}
