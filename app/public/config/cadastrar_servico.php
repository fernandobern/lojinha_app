<div class="card">
    <h2>Cadastrar Serviço</h2>
    <form action="../../includes/salvar_servico.php" method="POST">
        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" required>

        <label for="valor">Valor:</label>
        <input type="number" name="valor" step="0.01">

        <label for="duracao">Duração:</label>
        <input type="time" name="duracao">

        <button type="submit">Salvar</button>
    </form>
</div>
