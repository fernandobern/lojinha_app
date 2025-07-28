<!-- LOGIN DE USUÁRIO -->
<?php
session_start();
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password, user_type FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }

    $stmt->bind_param("s", $username); // Correto: apenas 1 parâmetro, tipo string
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fetched_username, $hashed_password, $user_type);
        $stmt->fetch();

        // Debug temporário (remova em produção)
        echo "Hash armazenado: $hashed_password<br>";
        echo "Senha fornecida: $password<br>";

        if (password_verify($password, $hashed_password)) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $fetched_username;
            $_SESSION['user_type'] = $user_type;

            if ($user_type === 1) {
                header("Location: ../public/config.php");
                exit();
            } else {
                header("Location: ../public/cadastro_cliente.php"); // exemplo para outros tipos
                exit();
            }
        } else {
            echo "Senha incorreta.<br>";
        }
    } else {
        echo "Usuário não encontrado.<br>";
    }

    $stmt->close();
}
$conn->close();
?>
