<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Acompanhamento do Dia</title>
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/main.css">
    
    <style>
        body {
            font-family: sans-serif;
            background-color: #f3f3f3;
            padding: 20px;
        }
        h1 {
            color: #ccc;
            margin-bottom: 20px;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .card {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 12px;
            padding: 16px;
            max-width: 350px;
            flex: 1 1 300px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card p {
            margin: 6px 0;
        }
        .botoes {
            margin-top: 10px;
        }
        .botoes button {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            margin-right: 10px;
            cursor: pointer;
            color: white;
        }
        .btn-concluir { background-color: #27ae60; }
        .btn-observacao { background-color: #f1c40f; color: black; }
        .btn-devolver { background-color:rgb(207, 21, 21); }
    </style>
</head>
<body>
    <?php include ('../templates/header.php'); ?>
    <br>
    <h1 class="container">Acompanhamento de Banhos de Hoje</h1>
    <div class="cards-container container" id="cards-container"></div>
    
    <script>
        async function carregarAgendamentos() {
            const response = await fetch('../includes/listar_agendamentos_dia.php');
            const agendamentos = await response.json();

            const container = document.getElementById('cards-container');
            container.innerHTML = '';

            if (agendamentos.length === 0) {
                container.innerHTML = '<p style="color: red;">Nenhum pet agendado com status "banho" para hoje.</p><a class="menu_button" href="../public/agendamentos.php">consultar AGENDA</a>';
                return;
            }

            agendamentos.forEach( pet => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
                    <p><strong>Id:</strong> ${pet.id}</p>
                    <p><strong>ID data:</strong> ${pet.data_id}</p>
                    <p><strong>Pet:</strong> ${pet.pet} (${pet.peso}kg, ${pet.raca}, ${pet.idade} anos)</p>
                    <p><strong>Cliente:</strong> ${pet.cliente}</p>
                    <p><strong>Serviço:</strong> ${pet.servico} - R$ ${parseFloat(pet.valor).toFixed(2)}</p>

                    <p><strong>Obs. Cliente:</strong> ${pet.obs_cliente || '---'}</p>
                    <p><strong>Data:</strong> ${pet.data || 'NÃO INFORMADO'}</p>
                    <p><strong>Hora:</strong> ${pet.hora || '--:--'}</p>

                    <p><strong>Status:</strong> ${pet.status}</p>
                    <div class="botoes">
                        <button class="btn-concluir" onclick="concluirBanho(${pet.data_id})">Concluir</button>
                        <button class="btn-observacao" onclick="adicionarObs(${pet.id})">Obs.</button>
                        <button class="btn-devolver" onclick="devolverPet(${pet.id})">Devolver</button>
                    </div>
                `;
                container.appendChild(card);
            });
        }

        function concluirBanho(data_id, pet_id, cliente) {
            //alert(`Iniciar banho para o agendamento ${data_id}`);
            if (confirm(`Quer concluir o agendamento para o Pet ${pet_id}, do cliente ${cliente} ?`)) {
                window.location = `../includes/functions/concluir_banho.php?data_id=${data_id}`;
            }
            // Aqui você pode fazer uma chamada AJAX para mudar o status no banco
            //no momento vou usar o arquivo PHP
        }

        function adicionarObs(id) {
            const obs = prompt("Digite a observação:");
            if (obs) {
                alert(`Salvar observação para ${id}: ${obs}`);
                // Aqui você pode salvar no banco via AJAX
            }
        }

        function devolverPet(id) {
            alert(`Devolver pet do agendamento ${id}`);
            // Aqui você pode registrar a devolução
        }

        carregarAgendamentos();
    </script>
</body>
</html>
