<?php
require('conexao.php');

// ordenar as cidades por nome
$q = "SELECT * FROM cidades ORDER BY nome ASC";
$cidades = mysqli_query($con, $q);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Melhorias Municipais</title>
    
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- titulo -->
        <h1>Sistema de Melhorias Municipais</h1>
        
        <div class="cidades-container">
            <h2>Selecione uma Cidade</h2>
            
            <!-- grid que mostra os cards das cidades -->
            <div class="cidades-grid">
                <?php
                // verifica se tem cidades cadastradas
                if (mysqli_num_rows($cidades) > 0) {
                    // mostra todas as cidades
                    while ($cidade = mysqli_fetch_assoc($cidades)) {
                        // cria um card para cada cidade
                        echo '<div class="cidade-card">';
                        
                        echo '<h3>' . htmlspecialchars($cidade['nome']) . ' - ' . htmlspecialchars($cidade['estado']) . '</h3>';
                        echo '<div class="card-actions">';
                        // açõoes para cada cidade
                        echo '<a href="melhorias.php?cidade=' . $cidade['id'] . '" class="btn-ver">Ver Melhorias</a>';
                        echo '<a href="editar_cidade.php?id=' . $cidade['id'] . '" class="btn-editar">Editar</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Nenhuma cidade cadastrada.</p>';
                }
                ?>
            </div>

            <!-- botões principais -->
            <div class="actions">
                <a href="cadastrar_cidade.php" class="btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Nova Cidade
                </a>
                <br>
                <br>
                <a href="relatorios.php" class="btn-secondary">
                    <i class="fas fa-chart-bar"></i> Ver Relatórios
                </a>
            </div>
        </div>
    </div>
</body>
</html> 