<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #fafafa;
        }
        h1 {
            margin-bottom: 20px;
        }
        .indicadores {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }
        .card {
            background: white;
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 16px;
            width: 220px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .charts, .listas {
            margin-top: 30px;
        }
        canvas {
            background-color: white;
            padding: 10px;
            border-radius: 8px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 4px;
        }
    </style>
</head>
<body>
    <h1>Relatórios do Sistema</h1>

    <div class="indicadores" id="indicadores"></div>

    <div class="charts">
        <h2>Banhos por Dia</h2>
        <canvas id="banhosDiaChart"></canvas>

        <h2>Banhos por Mês</h2>
        <canvas id="banhosMesChart"></canvas>
    </div>

    <div class="listas">
        <h2>Serviços Mais Pedidos</h2>
        <ul id="servicos"></ul>

        <h2>Clientes com Mais Agendamentos</h2>
        <ul id="clientes"></ul>

        <h2>Pets Mais Atendidos</h2>
        <ul id="pets"></ul>
    </div>

    <script>
        async function carregarRelatorio() {
            const response = await fetch('../includes/relatorios/relatorio_dados.php');
            const data = await response.json();

            document.getElementById('indicadores').innerHTML = `
                <div class="card"><strong>Total de Banhos:</strong><br>${data.totalBanhos}</div>
                <div class="card"><strong>Valor Total:</strong><br>R$ ${data.valorTotal}</div>
                <div class="card"><strong>Ticket Médio:</strong><br>R$ ${data.ticketMedio}</div>
                <div class="card"><strong>Dia Mais Movimentado:</strong><br>${data.diaMaisMovimento.data_execucao} (${data.diaMaisMovimento.total})</div>
            `;

            // Gráfico de banhos por dia
            const ctx1 = document.getElementById('banhosDiaChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: data.banhosPorDia.map(e => e.data),
                    datasets: [{
                        label: 'Banhos',
                        data: data.banhosPorDia.map(e => e.total),
                        backgroundColor: '#3498db66',
                        borderColor: '#2980b9',
                        borderWidth: 2,
                        tension: 0.2,
                        fill: true
                    }]
                }
            });

            // Gráfico de banhos por mês
            const ctx2 = document.getElementById('banhosMesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'bar',
                data: {
                    labels: data.banhosPorMes.map(e => e.mes),
                    datasets: [{
                        label: 'Banhos',
                        data: data.banhosPorMes.map(e => e.total),
                        backgroundColor: '#2ecc71'
                    }]
                }
            });

            // Listas
            const ulServicos = document.getElementById('servicos');
            data.servicosMaisPedidos.forEach(s => {
                ulServicos.innerHTML += `<li>${s.descricao} (${s.total})</li>`;
            });

            const ulClientes = document.getElementById('clientes');
            data.clientesTop.forEach(c => {
                ulClientes.innerHTML += `<li>${c.nome} (${c.total})</li>`;
            });

            const ulPets = document.getElementById('pets');
            data.petsTop.forEach(p => {
                ulPets.innerHTML += `<li>${p.nome} (${p.total})</li>`;
            });
        }

        carregarRelatorio();
    </script>
</body>
</html>
