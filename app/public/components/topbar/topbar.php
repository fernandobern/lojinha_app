<?php
echo '
<div class="topbar">

    <div class="topbar-item">
        <a href="calendar.php" class="btn-action" title="Visualizar calendário">
            📅 <span>Calendário</span>
        </a>
    </div>

    <div class="topbar-item">
        <a href="historico.php" class="btn-action" title="Histórico de agendamentos">
            🕓 <span>Histórico</span>
        </a>
    </div>

    <div class="topbar-item">
        <a href="agenda_excluida.php" class="btn-action btn-trash" title="Agendamentos excluídos">
            🗑️ <span>Lixeira</span>
        </a>
    </div>

</div>

<style>
.topbar {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap; /* impede quebra feia em telas menores */
    gap: 16px;
    background: #ffffff;
    border-radius: 12px;
    padding: 15px 20px;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 25px;
}

.topbar-item {
    display: flex;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none;
    color: #333;
    background: #f5f6fa;
    padding: 10px 18px;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
    min-width: 130px;
    text-align: center;
    transition: all 0.3s ease;
}

.btn-action:hover {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
    transform: translateY(-2px);
}

.btn-trash {
    background: #fff0f0;
    border-color: #f5c2c2;
}

.btn-trash:hover {
    background: #dc3545;
    color: #fff;
    border-color: #dc3545;
}

.btn-action span {
    font-size: 14px;
}
</style>
';
?>
