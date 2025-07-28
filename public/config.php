<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Configuração</title>
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
<body class="container">
    <?php
        include_once '../templates/header.php'
    ?>
    <h1>Configurações do Sistema</h1>

</body>
</html>
