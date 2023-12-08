<?php
require_once('banco.php');

// Conecte-se ao banco de dados (substitua com suas credenciais)
$conn = new mysqli("localhost", "root", "", "usuarios");

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verifique se um token válido foi fornecido na URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Consulta para verificar se o token existe e está dentro do prazo de validade
    $sql = "SELECT * FROM usuarios WHERE token_recuperacao = '$token' AND data_expiracao > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Token válido, permita ao usuário redefinir a senha
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novaSenha = $_POST['nova_senha'];
            $confirmarSenha = $_POST['confirmar_senha'];

            

            // Verifique se as senhas coincidem
            if ($novaSenha === $confirmarSenha) {
                // Hash da nova senha (use a função de hash apropriada, como password_hash)
                $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);

                // Atualize a senha do usuário no banco de dados
                $sql = "UPDATE usuarios SET senhahash = '$senhaHash', token_recuperacao = NULL, data_expiracao = NULL WHERE token_recuperacao = '$token'";
                if ($conn->query($sql) === TRUE) {
                    echo "Senha redefinida com sucesso.";
                    echo "<script>alert('Senha Atualizada, Retornando a Página de Login!');window.location='login.html';</script>";
                } else {
                    echo "Erro ao redefinir a senha: " . $conn->error;
                }
            } else {
                echo "As senhas não coincidem.";
            }
        }
    } else {
        echo "<script>alert('Token Inválido ou Expirado, Tente novamente!');window.location='login.html';</script>";
    }
} else {
    echo "Token de recuperação não fornecido na URL.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="redefinirsenha.css">
</head>
<header>
        <img src="HEALNUTRI-removebg-preview.png" width="20%">
    </header>
<body>
<div id="Cadastrar">
    <form method="post" class='card'>
<div class="card-header">
    <h2>Mudar a senha</h2>
</div>
<div class="card-content-area">
    <label for="password">Nova senha</label>
    <input type="password" id="password" name="nova_senha" autocomplete="off">
</div>
<div class="card-content-area">
    <label for="confirmar_senha">Comfirmar a Senha</label>
    <input type="password" id="confirmar_senha" name="confirmar_senha" autocomplete="off">
</div>
<div class="card-footer">
        <input class="submit" type="submit" value="Enviar dados!">
    </div>  
    </form>
</div>
</body>
</html>
