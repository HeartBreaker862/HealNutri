<?php 
require_once('banco.php'); 

if ($_POST) {
    $biotipo = $_POST['biotipo'];
    $senha = $_POST['senha'];
    $login = $_POST['login']; // email
    $nome = $_POST['nome'];
    $altura = $_POST['altura'];
    $peso = $_POST['peso'];
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $nivelAtividade = $_POST['nivel_atividade']; // Captura o valor do nível de atividade
    $senhahash = password_hash($senha, PASSWORD_DEFAULT);

    $conn = abre_bd();
    
    // Verifica se a coluna nivel_atividade existe na tabela usuarios
    $result = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'nivel_atividade'");
    $columnExists = $result->num_rows > 0;

    // Se a coluna não existir, adiciona ela à tabela
    if (!$columnExists) {
        $addColumnSql = "ALTER TABLE usuarios ADD nivel_atividade VARCHAR(10)";
        $conn->query($addColumnSql);
    }

    // Verifica se o email já está registrado
    $emailExistsQuery = "SELECT * FROM usuarios WHERE login = ?";
    $stmtEmailExists = $conn->prepare($emailExistsQuery);
    $stmtEmailExists->bind_param("s", $login);
    $stmtEmailExists->execute();
    $stmtEmailExists->store_result();
    
    if ($stmtEmailExists->num_rows > 0) {
        echo "<script>alert('O email já está registrado.');window.location='login.html';</script>";
        exit;
    }

    // Inserção do novo usuário no banco de dados
    $sql = "INSERT INTO usuarios (senhahash, login, nome, altura, peso, idade, genero, nivel_atividade, biotipo) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error: " . mysqli_error($conn);
        exit();
    }

    $stmt->bind_param("sssssssss", $senhahash, $login, $nome, $altura, $peso, $idade, $genero, $nivelAtividade, $biotipo);

    $stmt->execute();

    $linhas = $stmt->affected_rows;

    fecha_bd($conn);

    if ($linhas > 0)
        echo "<script>alert('Contato salvo com sucesso! Faça login para continuar!');window.location='login.html';</script>";
    else
        header('location: login.html');
}
?>
