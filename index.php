<?php
// Inclui o arquivo de conexão com o banco de dados
require('conexao.php');

// Consulta SQL para buscar todas as cidades ordenadas por nome
$q = "SELECT * FROM cidades ORDER BY nome ASC";
$cidades = mysqli_query($con, $q);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Melhorias Municipais</title>
    
    <!-- Carregamento dos arquivos CSS e fontes -->
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Título principal da página -->
        <h1>Sistema de Melhorias Municipais</h1>
        
        <div class="cidades-container">
            <h2>Selecione uma Cidade</h2>
            
            <!-- Grid que vai mostrar os cards das cidades -->
            <div class="cidades-grid">
                <?php
                // Verifica se existem cidades cadastradas
                if (mysqli_num_rows($cidades) > 0) {
                    // Loop para mostrar cada cidade
                    while ($cidade = mysqli_fetch_assoc($cidades)) {
                        // Cria um card para cada cidade
                        echo '<div class="cidade-card">';
                        // Mostra nome e estado da cidade (htmlspecialchars previne XSS)
                        echo '<h3>' . htmlspecialchars($cidade['nome']) . ' - ' . htmlspecialchars($cidade['estado']) . '</h3>';
                        echo '<div class="card-actions">';
                        // Botões de ação para cada cidade
                        echo '<a href="melhorias.php?cidade=' . $cidade['id'] . '" class="btn-ver">Ver Melhorias</a>';
                        echo '<a href="editar_cidade.php?id=' . $cidade['id'] . '" class="btn-editar">Editar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    // Mensagem caso não existam cidades cadastradas
                    echo '<p>Nenhuma cidade cadastrada.</p>';
                }
                ?>
            </div>

            <!-- Seção de botões de ação principais -->
            <div class="actions">
                <!-- Botão para cadastrar nova cidade -->
                <a href="cadastrar_cidade.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Nova Cidade
                </a>
                <br>
                <br>
                <!-- Botão para ver relatórios -->
                <a href="relatorios.php" class="btn-secondary">
                    <i class="fas fa-chart-bar"></i> Ver Relatórios
                </a>
            </div>
        </div>
    </div>
</body>
</html> 