<?php
require_once('banco.php');

// Conecte-se ao banco de dados (substitua com suas credenciais)
$conn = new mysqli("localhost", "root", "", "usuarios");

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obtenha o endereço de e-mail fornecido pelo usuário
$email = $_POST['login'];

// Verifique se o e-mail existe no banco de dados
$sql = "SELECT * FROM usuarios WHERE login = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // O e-mail existe, gere um token de recuperação e o armazene no banco de dados
    $token = bin2hex(random_bytes(16)); // Gera um token aleatório
    $data_expiracao = date('Y-m-d H:i:s', strtotime('+1 hour')); // Data de expiração (1 hora a partir de agora)

    // Insira o token e a data de expiração no banco de dados
    $sql = "UPDATE usuarios SET token_recuperacao = '$token', data_expiracao = '$data_expiracao' WHERE login = '$email'";
    if ($conn->query($sql) === TRUE) {
        // Agora você deve enviar um e-mail ao usuário com um link contendo o token de recuperação
        // Redirecione o usuário para a página de redefinição de senha
        header("Location: redefinir_senha.php?token=$token");
    } else {
        echo "Erro ao atualizar o token de recuperação: " . $conn->error;
    }
} else {
    echo "E-mail não encontrado no sistema.";
}

$conn->close();
?>
