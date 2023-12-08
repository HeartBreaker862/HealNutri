<?php
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "usuarios");

// Verificar se houve algum erro de conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

// Verificar se a dieta foi selecionada
if (!isset($_SESSION['dieta'])) {
    header("Location: index.php");
    exit();
}

// Dados do usuário
$calorias = $_SESSION['usuario']['calorias'];
$escolha = $_SESSION['usuario']['dieta'];
$genero = $_SESSION['usuario']['genero']; // 'M' para masculino, 'F' para feminino
$peso = $_SESSION['usuario']['peso']; // em kg
$altura = $_SESSION['usuario']['altura']; // em cm
$idade = $_SESSION['usuario']['idade']; // em anos
$nivelAtividade = $_SESSION['usuario']['nivel_atividade'];
$nome = $_SESSION['usuario']['nome'];
$biotipo = $_SESSION['usuario']['biotipo'];



// Fator de atividade
$fatorAtividade = 1.55; // Exemplo: ativo moderadamente

// Equação Mifflin-St Jeor para homens
if ($genero === 'Masculino') {
    $caloriasBasais = (10 * $peso) + (6.25 * $altura) - (5 * $idade) + 5;
}
// Equação Mifflin-St Jeor para mulheres
elseif ($genero === 'Feminino') {
    $caloriasBasais = (10 * $peso) + (6.25 * $altura) - (5 * $idade) - 161;
}

// Necessidades calóricas totais
$necessidadesCaloricas = $caloriasBasais * $nivelAtividade;
$necessidadesCaloricasInteiro = round($necessidadesCaloricas);
$calorias = $necessidadesCaloricasInteiro;



// Cálculo do IMC
$alturaMetros = $altura / 100; // Converter altura para metros
$imc = $peso / ($alturaMetros * $alturaMetros);

// Mensagem de status do IMC
if ($imc < 18.5) {
    $statusImc = "Abaixo do Peso";
} elseif ($imc >= 18.5 && $imc < 25) {
    $statusImc = "Peso Normal";
} elseif ($imc >= 25 && $imc < 30) {
    $statusImc = "Sobrepeso";
} else {
    $statusImc = "Obesidade";
}

$ingestaoAgua = $peso * 0.035;

if ($escolha == 'Ganho' && $biotipo == 'Mesomorfo') { // Ganho de Massa Mesomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipmeso = ($lipidioganho * 0.30) / 9;
    $proteinaganho = $peso;
    $resultadopromeso = $proteinaganho * 2.5;
    $carboganho = $peso;
    $resultadocarmeso = $carboganho * 4;
    $resultadoobjetivoganho = ($resultadopromeso * 4) + ($lipidioganho * 0.30) + ($resultadocarmeso * 4);
    $resultadolipmesointeiro = round($resultadolipmeso, 1);
}

if ($escolha == 'Emagrecer' && $biotipo == 'Mesomorfo') { // Emagrecimento Mesomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipmeso = ($lipidioganho * 0.25) / 9;
    $proteinaganho = $peso;
    $resultadopromeso = $proteinaganho * 1.5;
    $carboganho = $necessidadesCaloricasInteiro;
    $resultadocarmeso = ($carboganho * 0.25) / 4;
    $resultadoobjetivoemagrecer = ($resultadopromeso * 4) + ($lipidioganho * 0.30) + ($carboganho * 0.20);
    $resultadolipmesointeiro = round($resultadolipmeso, 1);
    $resultadocarmesointeiro = round($resultadocarmeso, 1);
}

if ($escolha == 'Ganho' && $biotipo == 'Ectomorfo') {  // Ganho Ectomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipecto = ($lipidioganho * 0.30) / 9;
    $proteinaganho = $peso;
    $resultadoproecto = $proteinaganho * 3;
    $carboganho = $peso;
    $resultadocarecto = $carboganho * 6;
    $resultadoobjetivoganho = ($resultadoproecto * 4) + ($lipidioganho * 0.30) + ($resultadocarecto * 4);
    $resultadolipectointeiro = round($resultadolipecto, 1);
}

if ($escolha == 'Emagrecer' && $biotipo == 'Ectomorfo') { // Emagrecimento Ectomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipecto = ($lipidioganho * 0.25) / 9;
    $proteinaganho = $peso;
    $resultadoproecto = $proteinaganho * 1.5;
    $carboganho = $necessidadesCaloricasInteiro;
    $resultadocarecto = ($carboganho * 0.25) / 4;
    $resultadoobjetivoemagrecer = ($resultadoproecto * 4) + ($lipidioganho * 0.30) + ($carboganho * 0.20);
    $resultadolipectointeiro = round($resultadolipecto, 1);
    $resultadocarectointeiro = round($resultadocarecto, 1);
}

if ($escolha == 'Ganho' && $biotipo == 'Endomorfo') { // Ganho Endomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipendo = ($lipidioganho * 0.25) / 9;
    $proteinaganho = $peso;
    $resultadoproendo = $proteinaganho * 2.5;
    $carboganho = $peso;
    $resultadocarendo = $carboganho * 5;
    $resultadoobjetivoganho = ($resultadoproendo * 4) + ($lipidioganho * 0.30) + ($resultadocarendo * 4);
    $resultadolipendointeiro = round($resultadolipendo, 1);
}

if ($escolha == 'Emagrecer' && $biotipo == 'Endomorfo') { // Emagrecimento Endomorfo
    $lipidioganho = $necessidadesCaloricasInteiro;
    $resultadolipendo = ($lipidioganho * 0.30) / 9;
    $proteinaganho = $peso;
    $resultadoproendo = $proteinaganho * 1.2;
    $carboganho = $necessidadesCaloricasInteiro;
    $resultadocarendo = ($carboganho * 0.20) / 4;
    $resultadoobjetivoemagrecer = ($resultadoproendo * 4) + ($lipidioganho * 0.30) + ($carboganho * 0.20);
    $resultadolipendointeiro = round($resultadolipendo, 1);
    $resultadocarendointeiro = round($resultadocarendo, 1);
}



$usuarioID = $_SESSION['usuario']['ID'];
$sql = "UPDATE usuarios set calorias = '$calorias' WHERE id ='$usuarioID'";
if($conn->query($sql) === TRUE) {
    // Atualização bem-sucedida
    
    // Armazenar a dieta na sessão
    $_SESSION['calorias'] = $calorias;
    
    // Redirecionar para a página de sucesso ou outra página desejada
} else {
    echo "Erro ao atualizar as calorias no banco de dados: " . $conn->error;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sucesso.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,200;1,200&display=swap" rel="stylesheet">
    <title>HealNutri: Informações do Usuário</title>
</head>
<body>
    <header>
        
        <?php 
            echo "<img src='HEALNUTRI-removebg-preview.png' width='18%' class='logo'>";
            echo "<h1 class='logo' >$nome</h1>" ?>
        <form method="post" action="troca_dados.php">
    <input type="submit" name="excluir_dieta" class="obten" value="Trocar Objetivo">
</form>

    </header>

    <main>
        <div class="informacoes_usuario">
            <h2 class="perf">Perfil</h2>
            <div class="lista_informacoes">
            <?php
            if($genero == "Masculino"){
                echo "<div class='img'>
                <img src='Homem.png' width='70%'>
                </div>";
            }
            if($genero == "Feminino"){
                echo "<div class='img'>
                <img src='Mulher.png' width='85%'>
                </div>";
            }
            ?>

                <ul>
                    <li class="informacao">Gênero: <?php echo $genero; ?></li>
                    <li class="informacao">Peso: <?php echo $peso; ?> kg</li>
                    <li class="informacao">Altura: <?php echo $altura; ?> cm</li>
                    <li class="informacao">Idade: <?php echo $idade; ?> anos</li>
                    <li class="informacao">Biotipo: <?php echo $biotipo; ?></li>
                    <li class="informacao">Nível de Atividade: <?php echo $nivelAtividade; ?></li>
                </ul>
            </div>

        <div class="calculos">
                <h2 class="titulo_calculos">Cálculos</h2>
                <?php
                if($escolha == 'Alimento') {
                    echo "<p class='texto'>Suas necessidades calóricas totais são aproximadamente: $necessidadesCaloricasInteiro calorias por dia.</p>";
                }
                ?>
                <?php
                if($escolha == 'Emagrecer') {
                    echo "Objetivo de calorias para o emagrecimento: $resultadoobjetivoemagrecer kcal<br>";
                }

                if($escolha == 'Ganho') {
                    echo "Objetivo de calorias para o ganho: $resultadoobjetivoganho kcal<br>";
                }
                ?>
                <?php if($escolha == 'Ganho' && $biotipo == 'Mesomorfo') {
                    echo "Quantidade de Proteínas diárias para o Ganho: $resultadopromeso gramas<br>"; 
                    echo "Quantidade de Carboidratos diários para o Ganho: $resultadocarmeso gramas<br>"; 
                    echo "Quantidade de Lipidios diários para o Ganho: $resultadolipmesointeiro gramas<br>"; 
                }
                ?>
                <?php if($escolha == 'Emagrecer' && $biotipo == 'Mesomorfo') {
                    echo "Quantidade de Proteínas diárias para o Emagrecer: $resultadopromeso gramas<br>"; 
                    echo "Quantidade de Carboidratos diários para o Emagrecer: $resultadocarmesointeiro gramas<br>"; 
                    echo "Quantidade de Lipidios diários para o Emagrecer: $resultadolipmesointeiro gramas<br>"; 
                }
                ?>
                <?php if($escolha == 'Ganho' && $biotipo == 'Ectomorfo') {
                    echo "Quantidade de Proteínas diárias para Ganho: $resultadoproecto gramas<br>"; 
                    echo "Quantidade de Carboidratos diários para Ganho: $resultadocarecto gramas<br>"; 
                    echo "Quantidade de Lipidios diários para Ganho: $resultadolipectointeiro gramas<br>"; 
                }
                ?>
                <?php if($escolha == 'Emagrecer' && $biotipo == 'Ectomorfo') {
                    echo "Quantidade de Proteínas diárias para o Emagrecer: $resultadoproecto gramas<br>"; 
                    echo "Quantidade de Carboidratos diários para o Emagrecer: $resultadocarectointeiro gramas<br>"; 
                    echo "Quantidade de Lipidios diários para o Emagrecer: $resultadolipectointeiro gramas<br>"; 
                }
                ?>
                <?php if($escolha == 'Ganho' && $biotipo == 'Endomorfo') {
                    echo "Quantidade de Proteínas diárias para Ganho: $resultadoproendo gramas<br>"; 
                    echo "Quantidade de Carboidratos diários para Ganho: $resultadocarendo gramas<br>"; 
                    echo "Quantidade de Lipidios diários para Ganho: $resultadolipendointeiro gramas<br>"; 
                }
                ?>

                <?php if($escolha == 'Emagrecer' && $biotipo == 'Endomorfo') {
                    echo "Quantidade de Proteínas diárias para Emagrecer: $resultadoproendo gramas<br><br>"; 
                    echo "Quantidade de Carboidratos diários para Emagrecer: $resultadocarendointeiro gramas<br><br>"; 
                    echo "Quantidade de Lipidios diários para Emagrecer: $resultadolipendointeiro gramas<br><br>"; 
                    echo "Objetivo de calorias para o emagrecimento: $resultadoobjetivo kcal<br>"; 
                }
                ?>
                <p class="texto">Seu Índice de Massa Corporal (IMC) é: <?php echo round($imc, 2); ?></p>
                <p class="texto">Status do IMC: <?php echo $statusImc; ?></p>
            </div> 
            
            



        <div class="agua">
             <p class="ag">Recomenda-se beber aproximadamente <?php echo round($ingestaoAgua, 2); ?> litros de água por dia.</p>
             <div class="img">
                <img src="pngtree-drinking-water-glassware-image_1459568-removebg-preview.png" width="200px" height="200px">
             </div>
             
        </div>

        <ul>
                <li class="site"><a href="obtencao.html" class="site">Mudar Altura/Peso/Idade</a></li>
                <li class="site"><a href="inicial.html">Sair</a></li>
            </ul>
        
        </div>

        <div class="sugestoes">
            <div class="tit">
                <h4>Sugestões<h4><br>
            </div>
                <?php if($escolha == 'Alimento') {
                    echo "<h4 align='center'>Alimentação Saudável</h4>";

                    echo "<div class='img'>";
                    echo "<img src='Alimento.png' width='30%'>";
                    echo "</div>";
                    
                    echo "Uma alimentação saudável é essencial para manter o bom funcionamento do corpo e prevenir doenças. Aqui estão alguns alimentos que são geralmente considerados saudáveis e que podem fazer parte de uma dieta equilibrada:

                    <table>
                    <tr>
                        <th>Categoria</th>
                        <th>Alimentos</th>
                    </tr>
                    <tr>
                        <td>Frutas</td>
                        <td>Frutas, Maçãs, Bananas, Laranjas, Morangos, Abacaxis, Uvas, Kiwi, Melancias, Mirtilos, Pêssegos</td>
                    </tr>
                    <tr>
                        <td>Legumes</td>
                        <td>Espinafre, Brócolis, Cenouras, Couve, Abobrinha, Tomates, Pimentões, Berinjelas, Couve-de-bruxelas, Aspargos</td>
                    </tr>
                    <tr>
                        <td>Grãos Integrais</td>
                        <td>Alimentos como arroz integral, quinoa, aveia e pão integral são boas fontes de fibras, vitaminas e minerais.</td>
                    </tr>
                    <tr>
                        <td>Proteínas Magras</td>
                        <td>Peito de frango, peixe, carne magra, ovos, tofu e leguminosas (feijões, lentilhas, grão-de-bico) são excelentes fontes de proteína.</td>
                    </tr>
                    <tr>
                        <td>Laticínios com Baixo Teor de Gordura</td>
                        <td>Leite, iogurte e queijo com baixo teor de gordura fornecem cálcio e proteínas importantes para a saúde óssea.</td>
                    </tr>
                    <tr>
                        <td>Gorduras Saudáveis</td>
                        <td>Abacate, nozes, sementes, azeite de oliva e peixes gordurosos (como salmão) contêm ácidos graxos ômega-3 e ômega-6, que são benéficos para a saúde cardiovascular.</td>
                    </tr>
                    <tr>
                        <td>Legumes e Verduras de Folhas Verdes</td>
                        <td>Espinafre, couve, alface e outros vegetais de folhas verdes são ricos em nutrientes como ferro, cálcio e fibras.</td>
                    </tr>
                    <tr>
                        <td>Frutas Secas</td>
                        <td>Nozes, amêndoas, pistaches, e outras frutas secas são boas fontes de proteínas, fibras e gorduras saudáveis.</td>
                    </tr>
                    <tr>
                        <td>Alimentos Fermentados</td>
                        <td>Iogurte natural, kefir, chucrute e kimchi são ricos em probióticos que promovem uma boa saúde intestinal.</td>
                    </tr>
                    <tr>
                        <td>Ervas e Temperos</td>
                        <td>Utilize ervas frescas e especiarias para adicionar sabor às refeições sem a necessidade de muito sal e açúcar.</td>
                    </tr>
                </table>";
                    }   
                    if ($escolha == 'Ganho') {
                        echo "<div class='img'>";
                        echo "<img src='Ganho.png' width='30%'>";
                        echo "</div>";

                        echo "<h4 align='center'>Ganho de Peso</h4><br><br>";

                        echo "Para ganhar peso, é necessário consumir mais calorias do que se gasta. Isso pode ser feito através de alimentos ricos em calorias, proteínas e carboidratos.<br><br>
                        
                        Aqui estão algumas sugestões de comidas para comer para ganhar peso:<br><br>
                        
                        <h2>Alimentos para Ganhar Peso</h2>

                        <table>
                        <tr>
                            <th>Categoria</th>
                            <th>Alimentos</th>
                        </tr>
                        <tr>
                            <td>Proteínas</td>
                            <td>
                            Carnes vermelhas, Frango e peru, Peixes gordurosos, Ovos
                            </td>
                        </tr>
                        <tr>
                            <td>Carboidratos</td>
                            <td>
                            Massas integrais, Arroz integral, Pão integral, Batatas, Quinoa
                            </td>
                        </tr>
                        <tr>
                            <td>Gorduras Saudáveis</td>
                            <td>
                            Abacate, Nozes e sementes, Azeite de oliva, Manteiga de amendoim
                            </td>
                        </tr>
                        <tr>
                            <td>Laticínios</td>
                            <td>
                                Leite integral, Iogurte grego, Queijos
                            </td>
                        </tr>
                        <tr>
                            <td>Snacks e Extras</td>
                            <td>
                            Barras de proteína, Smoothies (Combinando frutas, leite e proteínas), Granola (Adicione a iogurtes ou consuma com leite).
                            </td>
                        </tr>
                        <tr>
                            <td>Refeições Extras</td>
                            <td>
                                Aumente as porções: Aumente as quantidades nas refeições regulares.<br>
                                Adicione calorias: Adicione azeite de oliva, queijos ou molhos a pratos.
                            </td>
                        </tr>
                        <tr>
                            <td>Bebidas</td>
                            <td>
                                Smoothies calóricos: Use frutas, iogurte, leite e suplementos se necessário.<br>
                                Leite com chocolate ou achocolatado: Rica fonte de calorias.
                            </td>
                        </tr>
                    </table>
                        
                        É importante consultar um nutricionista para obter orientações personalizadas sobre como alcançar seus objetivos alimentares.";
                        
                    } 
                    if($escolha == 'Emagrecer') {
                        echo "<div class='img'>";
                        echo "<img src='Emagrece.png' width='20%'>";
                        echo "</div>";
                        
                        echo "<h4 align='center'>Emagrecimento</h4><br>";

                        echo "Para emagrecer, é necessário consumir menos calorias do que se gasta. Isso pode ser feito através de alimentos ricos em nutrientes e fibras, que ajudam a saciar o apetite.<br><br>
                        
                        Aqui estão algumas sugestões de comidas para comer para emagrecer:<br><br>
                        
                        <h2>Alimentos para Emagrecer</h2>

                    <table>
                        <tr>
                            <th>Categoria</th>
                            <th>Alimentos</th>
                        </tr>
                        <tr>
                            <td>Frutas</td>
                            <td>Maçãs, Pêras, Berries (morangos, mirtilos, framboesas), Kiwi, Abacaxi, Grapefruit, Melancia</td>
                        </tr>
                        <tr>
                            <td>Legumes</td>
                            <td>Brócolis, Couve, Espinafre, Abobrinha, Cenouras, Tomates, Pepino</td>
                        </tr>
                        <tr>
                            <td>Cereais Integrais</td>
                            <td>Aveia, Quinoa, Arroz Integral, Cevada, Trigo Sarraceno, Cereal de Farelo, Granola com Baixo Teor de Açúcar, Flocos de Milho Integral, Farro, Cereal Integral sem Açúcar Adicionado</td>
                        </tr>
                        <tr>
                            <td>Proteínas Magras</td>
                            <td>Frango sem Pele, Peito de Peru, Peixe, Ovos, Carne Magra, Iogurte Grego sem Gordura, Queijo com Baixo Teor de Gordura, Tofu, Leguminosas, Peito de Pato sem Pele, Proteína de Soro de Leite (Whey Protein)</td>
                        </tr>
                        <tr>
                            <td>Gorduras Saudáveis</td>
                            <td>Abacate, Azeite de Oliva Extra Virgem, Nozes e Amêndoas, Sementes de Chia e Linhaça, Salmão, atum, sardinha, truta, Coco e Óleo de Coco, Ovos, Chocolate Amargo, Óleo de Abacate, Semente de Abóbora</td>
                        </tr>
                        <tr>
                            <td>Exemplos de Lanches</td>
                            <td>
                                Fruta com iogurte<br>
                                Salada de frutas<br>
                                Sopa de legumes<br>
                                Omelete com vegetais<br>
                                Smoothie de frutas e vegetais
                            </td>
                        </tr>
                    </table>
                        
                        É importante consultar um nutricionista para obter orientações personalizadas sobre como alcançar seus objetivos alimentares.<br><br>";
                    }
                ?>
        </div>

</body>
</html>