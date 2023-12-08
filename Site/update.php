<!DOCTYPE html>
<html>
<head>
    <title>Processar Atualização</title>
</head>
<body>
    <h1>Processar Atualização</h1>

    <?php
    require_once('banco.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conecte-se ao banco de dados (substitua com suas credenciais)
        
    // Conecte-se ao banco de dados (substitua com suas credenciais)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "usuarios";

    $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        $email = $_POST['login'];
        $altura = $_POST['altura'];
        $peso = $_POST['peso'];
        $idade = $_POST['idade'];
        $atividade = $_POST['nivel_atividade'];

        // Atualize os dados do usuário no banco de dados
        $sql = "UPDATE usuarios SET altura = '$altura', peso = '$peso', idade = '$idade', nivel_atividade = '$atividade' WHERE login = '$email'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Dados trocados faça login para continuar!');window.location='login.html';</script>";
            exit();
        } else {
            echo "Erro ao atualizar dados: " . $conn->error;
        }

        $conn->close();
    }
    ?>

</body>
</html>
