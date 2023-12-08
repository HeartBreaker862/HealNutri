<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;1,200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Tudo/Css/index.css">
    <title>HealNutri</title>
</head>
<header>
        <div class="logo">
        <img src="HEALNUTRI-removebg-preview.png" width="20%">
        </div>
    </header>
<body>
    <?php
    // Verificar se o usuário está logado
    session_start();
    if (!isset($_SESSION['usuario'])) {
        echo "<script>alert('Login não feito, Retornando a Página de Login!');window.location='login.html';</script>";
    }
    ?>
    <form method="post" action="processar_escolha.php">
        <div class="quest">
            <h3 style="font-size: 20px;">Qual seu objetivo de dieta?</h3>
            <div class="escolhas">
                <select id="dieta" name="dieta">
                    <option value="Ganho">Ganho de Massa</option>
                    <option value="Alimento">Alimentação Saudável</option>
                    <option value="Emagrecer">Emagrecimento</option>
                </select>
                <div class="decidido">
                    <br><input type="submit" value="Avançar">
                </div>
            </div>
        </div> 
    </form>
</body>
</html>
