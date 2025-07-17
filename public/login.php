<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lojinha Pet</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="container">
        <br><br><br>
        <header>
        <img src="../images/logo.png" alt="Sua Logo" class="logo">
        <br>
        </header>
    </div>
    <div class="container">
        <main>
            <div class="login-box">
                <h2>LOGIN</h2>
                <form action="../includes/login.php" method="POST">
                    <input type="text" name="username" placeholder="Usuário" required>
                    <input type="password" name="password" placeholder="Senha" required>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
