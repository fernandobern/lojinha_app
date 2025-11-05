<div class="card">
    <h2>Cadastrar Usuário</h2>
    <form action="../../includes/salvar_usuario.php" method="POST">
        <label for="name">Nome:</label>
        <input type="text" name="name" required>

        <label for="username">Usuário:</label>
        <input type="text" name="username">

        <label for="tel">Telefone:</label>
        <input type="text" name="tel">

        <label for="password">Senha:</label>
        <input type="password" name="password">

        <label for="departamento_id">Departamento:</label>
        <input type="number" name="departamento_id">

        <label for="user_type">Tipo de Usuário:</label>
        <select name="user_type">
            <option value="1">Administrador</option>
            <option value="2">Operador</option>
            <option value="3">Cliente</option>
        </select>

        <button type="submit">Salvar</button>
    </form>
</div>
