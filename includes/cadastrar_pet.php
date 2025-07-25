<?php
// Incluir arquivo de conexão com o banco de dados
include ('../includes/conexao.php');

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id =  $_POST["cliente_id"];
    if (isset($_POST["cadastrar_pet"])) {
        //capturar dados
        $name_pet = $_POST["name_pet"];
        $especie = $_POST["especie"];
        $raca = $_POST["raca"];
        $sex = $_POST["sex"];

        // Verifica se birth é nulo, vazio ou igual a '0000-00-00'
        $birth = $_POST['birth'] ?? null;
        if (empty($birth) || $birth === '0000-00-00') {
            $birth = 'não informado'; // ou $birth = 'não informado'; dependendo do que você quer salvar
        }

        $peso = $_POST["peso"];
        $idade = $_POST["idade"];  
        $observacoes = $_POST["observacoes"];
        $data_cadastro = $_POST["data_cadastro"];
        $cliente_id =  $_POST["cliente_id"];

        try {
            //criar query
            $query = "INSERT INTO pets (name, especie, cliente_id, raca, sexo, peso, idade, birth, created_at, observacoes) 
            VALUES (?,?,?,?,?,?,?,?,?,?)";

            //enviar dados
            $queryExec = $conn ->prepare($query);
            $queryExec -> bind_param("ssissiisss", $name_pet, $especie, $cliente_id, $raca, $sex, $peso, $idade, $birth, $data_cadastro, $observacoes);
            $queryExec->execute();
        } catch (error $e) {
            echo "ERRO NO ENVIO DOS DADOS:". $e -> getMessage() ."";
    }
    $conn->close();
    header("location:../public/index.php");
}}