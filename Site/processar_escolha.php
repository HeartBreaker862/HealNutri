<?php
session_start();
require_once('banco.php'); // Certifique-se de que este arquivo contém a conexão com o banco de dados

if (isset($_POST['dieta'])) {
    $dietaSelecionada = $_POST['dieta'];
    
    if(isset($_SESSION['usuario'])) {
        $idUser = $_SESSION['usuario']['ID'];
        
        // Conectar ao banco de dados
        $conn = new mysqli("localhost", "root", "", "usuarios");

        // Verificar se houve algum erro de conexão
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }
        
        // Atualizar a dieta do usuário no banco de dados
        $sql = "UPDATE usuarios SET dieta = '$dietaSelecionada' WHERE id = $idUser";
        if($conn->query($sql) === TRUE) {
            // Atualização bem-sucedida
            
            // Armazenar a dieta na sessão
            $_SESSION['dieta'] = $dietaSelecionada;
            
            // Redirecionar para a página de sucesso ou outra página desejada
            echo "<script>alert('Faça login novamente para ver mais!');window.location='login.html';</script>";
            exit();
        } else {
            echo "Erro ao atualizar a dieta no banco de dados: " . $conn->error;
        }
        
        // Fechar a conexão com o banco de dados
        $conn->close();
    }
} else {
    // A escolha da dieta não foi enviada
    echo "Escolha de dieta não enviada.";
}
?>
