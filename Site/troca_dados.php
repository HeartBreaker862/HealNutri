<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "usuarios");

// Verificar se houve algum erro de conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if (isset($_POST['excluir_dieta'])) {
    // Obtenha o ID do usuário
    $usuarioID = $_SESSION['usuario']['ID'];

    // Crie uma consulta SQL para atualizar a dieta para um valor nulo
    $sql = "UPDATE usuarios SET dieta = NULL WHERE id = $usuarioID";

    if ($conn->query($sql) === TRUE) {
        // A dieta foi removida com sucesso (definida como nula)

        // Remova a dieta da sessão
        unset($_SESSION['dieta']);

        // Redirecione o usuário para a página de seleção de dieta ou outra página desejada
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao atualizar a dieta no banco de dados: " . $conn->error;
    }
}
?>
