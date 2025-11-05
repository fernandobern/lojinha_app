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


        .modal {
  display: none; /* Esconde inicialmente */
  position: fixed;
  z-index: 999;
  left: 0; top: 0;
  width: 100%; height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* fundo escuro */
}

.modal-content {
  background-color: white;
  padding: 20px;
  width: 90%;
  max-width: 400px;
  margin: 10% auto;
  border-radius: 8px;
  box-shadow: 0 0 10px #000;
}
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

            if (agendamentos.length === 0 ) {
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

                    <p><strong>Status:</strong> ${pet.status_data}</p>
                    <div class="botoes">
                        <button class="btn-concluir" onclick="concluirBanho(${pet.data_id})">Concluir</button>
                        <button class="btn-observacao" onclick="abrirModal(${pet.data_id})">Obs.</button>
                        <button class="btn-devolver" onclick="devolverPet(${pet.id})">Devolver</button>
                    </div>

                        <!-- Modal -->
                    <div id="modalObs" class="modal">
                    <div class="modal-content">
                        <form id="formObs" action="../includes/functions/obsBanho.php" method="post">
                        <input type="hidden" name="data_id" id="data_id_modal">
                        <label for="obs">Observação:</label><br>
                        <textarea name="obs" id="obs_modal" rows="4" style="width: 100%;" placeholder="Nenhuma observação, digite para informar">${pet.obs_final || ''}</textarea><br>
                        <button type="submit">Salvar</button>
                        <button type="button" onclick="fecharModal()">Cancelar</button>
                        </form>
                    </div>
                    </div>
                `;
                container.appendChild(card);
            });
            
        }

        function concluirBanho(data_id, pet_id, cliente) {
            alert(`Concluir banho para o agendamento ${data_id}`);
            if (confirm(`Quer concluir o agendamento para o Pet ${pet_id}, do cliente ${cliente}?`)) {
                window.location = `../includes/functions/concluir_banho.php?data_id=${data_id}`;
            }
            // Aqui pode fazer uma chamada AJAX para mudar o status no banco
            // no momento vou usar o arquivo PHP
        }


        //modal pra adicionar a obs de forma mais simples
        function abrirModal(data_id) {
        document.getElementById("data_id_modal").value = data_id;
        document.getElementById("modalObs").style.display = "block";
        }

        function fecharModal() {
        document.getElementById("modalObs").style.display = "none";
        }


        function adicionarObs(data_id) {
            const obs = prompt("Digite a observação:");
            if (obs) {
                alert(`Salvar observação para ${id}: ${obs}`);
                if (confirm(`Salvando observação para o Pet ${pet_id}, do cliente ${cliente} ?`)) {
                window.location = `../includes/functions/obsBanho.php?data_id=${data_id}`;
            }
                // Aqui pode salvar no banco via AJAX
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
