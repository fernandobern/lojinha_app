<!-- LOGIN DE USUÁRIO -->
<?php
session_start();
include 'conexao.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Adicionando verificações de depuração
        echo "Hash armazenado: $hashed_password<br>";
        echo "Senha fornecida: $password<br>";

        if (password_verify($password, $hashed_password)) {
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            header("Location: ../public/clientes.php");
            exit();
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
