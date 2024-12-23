<?php
// Inclui arquivo de conexão com o banco
require('conexao.php');

// Query para buscar estatísticas por categoria
// Conta quantas melhorias existem em cada categoria
$q_categorias = "SELECT categoria, COUNT(*) as total FROM melhorias GROUP BY categoria";
$categorias = mysqli_query($con, $q_categorias);

// Query para buscar estatísticas por cidade
// Conta quantas melhorias cada cidade tem, incluindo cidades sem melhorias (LEFT JOIN)
$q_cidades = "SELECT c.nome, COUNT(m.id) as total_melhorias 
              FROM cidades c 
              LEFT JOIN melhorias m ON c.id = m.id_cidade 
              GROUP BY c.id";
$cidades = mysqli_query($con, $q_cidades);

// Query para buscar as 10 melhorias mais votadas
// Junta com a tabela de cidades para mostrar o nome da cidade
$q_votadas = "SELECT m.*, c.nome as cidade 
              FROM melhorias m 
              JOIN cidades c ON m.id_cidade = c.id 
              ORDER BY m.votos DESC 
              LIMIT 10";
$mais_votadas = mysqli_query($con, $q_votadas);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios e Estatísticas</title>
    <!-- Carregamento dos arquivos CSS e fontes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Relatórios e Estatísticas</h1>
        
        <!-- Seção de estatísticas por categoria -->
        <section class="relatorio-section">
            <h2>Melhorias por Categoria</h2>
            <div class="stats-grid">
                <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                    <div class="stat-card">
                        <h3><?php echo htmlspecialchars($cat['categoria']); ?></h3>
                        <p class="stat-number"><?php echo $cat['total']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
        
        <!-- Seção de estatísticas por cidade -->
        <section class="relatorio-section">
            <h2>Melhorias por Cidade</h2>
            <div class="stats-grid">
                <?php while ($cidade = mysqli_fetch_assoc($cidades)): ?>
                    <div class="stat-card">
                        <h3><?php echo htmlspecialchars($cidade['nome']); ?></h3>
                        <p class="stat-number"><?php echo $cidade['total_melhorias']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
        
        <!-- Seção das melhorias mais votadas -->
        <section class="relatorio-section">
            <h2>Melhorias Mais Votadas</h2>
            <div class="top-melhorias">
                <?php while ($melhoria = mysqli_fetch_assoc($mais_votadas)): ?>
                    <div class="melhoria-card">
                        <h3><?php echo htmlspecialchars($melhoria['titulo']); ?></h3>
                        <p class="cidade"><?php echo htmlspecialchars($melhoria['cidade']); ?></p>
                        <p class="votos">Votos: <?php echo $melhoria['votos']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
        
        <!-- Botão para voltar à página inicial -->
        <a href="index.php" class="btn-voltar">Voltar para o Início</a>
    </div>
</body>
</html> 