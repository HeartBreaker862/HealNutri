<?php
session_start();

require_once('banco.php');

// Verificar se o formulário de login foi enviado
if (isset($_POST['login']) && isset($_POST['senha'])) {
    // Encerrar a sessão do usuário atual
    session_unset();
    session_destroy();

    // Iniciar uma nova sessão para o novo usuário
    session_start();

    $email = $_POST['login'];
    $senha = $_POST['senha'];

    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "", "usuarios");

    // Verificar se houve algum erro de conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta para buscar o usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE login = '$email'";
    $result = $conn->query($sql);

    // Verificar se o usuário foi encontrado
    if ($result->num_rows > 0) {
        // Usuário encontrado, verificar a senha
        $usuario = $result->fetch_assoc();
        $senha_hash = $usuario['senhahash'];

        if (password_verify($senha, $senha_hash)) {
            // Senha correta, login bem-sucedido
            $_SESSION['usuario'] = $usuario;

            // Verificar se a dieta já foi selecionada
            if (isset($usuario['dieta'])) {
                // A dieta já foi selecionada anteriormente

                // Armazenar a dieta na sessão
                $_SESSION['dieta'] = $usuario['dieta'];

                // Redirecionar para a página de sucesso
                header("Location: sucesso.php");
                exit();
            } else {
                // A dieta ainda não foi selecionada

                // Redirecionar para a página de escolha da dieta
                header("Location: index.php");
                exit();
            }
        } else {
            // Senha incorreta
            echo "<script>alert('Senha incorreta');window.location='login.html';</script>";
        }
    } else {
        // Usuário não encontrado
        echo "<script>alert('Usuário não encontrado');window.location='login.html';</script>";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
}

// Código para encerrar a sessão (logout)
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

