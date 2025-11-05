<?php
include '../../includes/conexao.php';
include '../../includes/functions/getServices.php';

// Buscar os serviços ANTES de montar o HTML
$servicos = getServices($conn);


include '../../includes/functions/getUsers.php';
$usuarios = getUsers($conn);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Configuração</title>
    <link rel="stylesheet" href="../../css/config.css">
    <link rel="stylesheet" href="../../css/components.css">
    <link rel="stylesheet" href="../../css/header.css">
    <link rel="stylesheet" href="../../css/main.css">
</head>
<body>
    <!-- Header fixo -->
<header style="position: fixed; top: 0; left: 0; width: 100%; 
               background: #333; color: white; padding: 10px 20px; 
               display: flex; align-items: center; justify-content: space-between; 
               z-index: 1000; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">

  <!-- Botão de voltar -->
  <a href="../clientes.php" 
     style="background: #555; color: white; text-decoration: none; 
            padding: 8px 15px; border-radius: 5px; cursor: pointer;">
    ← Voltar
  </a>

  <h2 style="margin: 0;">Gestão do Sistema</h2>
</header>

<!-- Espaço para não ficar escondido atrás do header -->
<div style="height: 70px;"></div>

    <!-- =================== USUÁRIOS =================== -->
    <div class="cards">
        <h2 class="sub-title">Usuários</h2>

        <!-- LISTA DE USUÁRIOS -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuário</th>
                    <th>Telefone</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios ?? [])): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                            <td><?= htmlspecialchars($usuario['username']) ?></td>
                            <td><?= htmlspecialchars($usuario['tel'] ?? '') ?></td>
                            <td><?= htmlspecialchars($usuario['user_type']) ?></td>
                            
                            <td>
                                <a class="btn" href="editar_usuario.php?id=<?= urlencode($usuario['id']) ?>">Editar</a>
                                <a class="btn btn_red" href="../../includes/functions/deleteUser.php?id=<?= urlencode($usuario['id']) ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nenhum usuário cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- FORM DE CADASTRO -->
        <div class="form-section">
            <?php include './cadastrar_usuario.php'; ?>    
        </div>
    </div>

    <br><br>

    <!-- =================== SERVIÇOS =================== -->
    <div class="cards">
        <h2 class="sub-title">Serviços</h2>

        <!-- LISTA DE SERVIÇOS -->
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Serviço</th>
                    <th>Descrição</th>
                    <th>Duração</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($servicos)): ?>
                    <?php foreach ($servicos as $servico): ?>
                        <tr>
                            <td><?= htmlspecialchars($servico['id']) ?></td>
                            <td><?= htmlspecialchars($servico['descricao'] ?? $servico['name'] ?? '') ?></td>
                            <td><?= htmlspecialchars($servico['descricao_longa'] ?? $servico['descricao'] ?? '') ?></td>
                            <td><?= htmlspecialchars($servico['duracao'] ?? '') ?> <?= ($servico['duracao'] ? 'min' : '') ?></td>
                            <td>
                                <!-- <a class="btn" href="editar_servico.php?id=<?= urlencode($servico['id']) ?>">Editar</a> -->
                                <a class="btn btn_red" href="../../includes/functions/deleteServico.php?id=<?= urlencode($servico['id']) ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Nenhum serviço cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- FORM DE CADASTRO -->
        <div class="form-section">
            <?php include './cadastrar_servico.php'; ?>
        </div>
    </div>
</body>
</html>
