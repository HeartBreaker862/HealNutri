<!DOCTYPE html>
<html>
<head>
    <title>Atualizar Dados</title>
    <link rel="stylesheet" href="process.css">
</head>
<body>
<header>
    <img src="HEALNUTRI-removebg-preview.png" width="20%">
</header>
    <div class="head">
        <h1>Atualizar Dados</h1>
    </div>

    <?php
    require_once('banco.php');
    // Conecte-se ao banco de dados (substitua com suas credenciais)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "usuarios";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obtenha o e-mail fornecido pelo usuário
    $email = $_POST['login'];

    // Verifique se o e-mail existe no banco de dados
    $sql = "SELECT nome, altura, peso, idade, nivel_atividade FROM usuarios WHERE login = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nome = $row["nome"];
        $atividade = $row["nivel_atividade"];
        $altura = $row["altura"];
        $peso = $row["peso"];
        $idade = $row["idade"];

        echo "<div class='form'>";
        echo "<h3>$nome</h3>";
        echo "Digite seus dados abaixo:<br><br>";
        echo "<form action='update.php' method='post'>";
        echo "<input type='hidden' name='login' value='$email'>";
        echo "<label for='altura'>Altura:</label>";
        echo "<input type='number' id='altura' name='altura' min='45' max='300' autocomplete='off' required><br><br>";
        echo "<label for='peso'>Peso:</label>";
        echo "<input type='number' id='peso' name='peso' min='12' max='500' autocomplete='off' required><br><br>";
        echo "<label for='idade'>Idade:</label>";
        echo "<input type='number' id='idade' name='idade' min='2' max='150' autocomplete='off' required><br><br>";
        echo "<label for='nivel_atividade' id='nivel_atividade'>Nivel de Atividade:</label>
            <select name='nivel_atividade' id='nivel_atividade' required>
                <option value='1.2'>Sedentário</option>
                <option value='1.3'>Levemente Ativo</option>
                <option value='1.5'>Ativo Moderado</option>
                <option value='1.7'>Muito Ativo</option>
        </select><br><br>";
        echo "<button type='submit' class='but'>Salvar Dados</button>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<script>alert('E-mail não encontrado no sistema.');window.location='login.html';</script>";
    }

    $conn->close();
    ?>

</body>
</html>
