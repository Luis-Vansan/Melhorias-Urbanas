<?php
require('conexao.php');

$id_cidade = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 0;

// dados da cidade selecionada
$q_cidade = "SELECT * FROM cidades WHERE id = $id_cidade";
$cidade = mysqli_fetch_assoc(mysqli_query($con, $q_cidade));

// categoria: filtra por tipo de melhoria
// ordem: define se ordena por data ou votos
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$ordem = isset($_GET['ordem']) ? $_GET['ordem'] : 'data';

// query base para buscar melhorias desta cidade
$q_melhorias = "SELECT * FROM melhorias WHERE id_cidade = $id_cidade";

// filtro de categoria se foi selecionada
if ($categoria) {
    $q_melhorias .= " AND categoria = '" . mysqli_real_escape_string($con, $categoria) . "'";
}

// define a ordem: votos (decrescente) ou data de postagem (decrescente)
$ordem_sql = $ordem == 'votos' ? 'votos DESC' : 'data_postagem DESC';
$q_melhorias .= " ORDER BY $ordem_sql";

// todas as categorias distintas para o filtro dropdown
$q_categorias = "SELECT DISTINCT categoria FROM melhorias WHERE id_cidade = $id_cidade";
$categorias = mysqli_query($con, $q_categorias);

// query principal das melhorias
$melhorias = mysqli_query($con, $q_melhorias);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melhorias - <?php echo htmlspecialchars($cidade['nome']); ?></title>
    
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">

        <h1>Melhorias para <?php echo htmlspecialchars($cidade['nome']); ?> - <?php echo htmlspecialchars($cidade['estado']); ?></h1>
        
        <!-- botão de adicionar nova sugestão -->
        <div class="actions">
            <a href="adicionar_melhoria.php?cidade=<?php echo $id_cidade; ?>" class="btn-primary">
                <i class="fas fa-plus"></i> Sugerir Melhoria
            </a>
        </div>
        
        <div class="filtros">
            <!-- links para ordenar por data ou por votos -->
            <a href="?cidade=<?php echo $id_cidade; ?>&ordem=data" class="btn-filtro">Mais Recentes</a>
            <a href="?cidade=<?php echo $id_cidade; ?>&ordem=votos" class="btn-filtro">Mais Votadas</a>
            
            <!-- select para filtrar por categoria -->
            <select id="categoria-filtro" onchange="filtrarCategoria(this.value)" class="select-filtro">
                <option value="">Todas as Categorias</option>
                <?php while ($cat = mysqli_fetch_assoc($categorias)): ?>
                    <option value="<?php echo htmlspecialchars($cat['categoria']); ?>"
                            <?php echo $categoria == $cat['categoria'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['categoria']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- lista de todas as melhorias -->
        <div class="melhorias-lista">
            <?php while ($melhoria = mysqli_fetch_assoc($melhorias)): ?>
                <div class="melhoria-card">
                    <!-- Titulo e categoria -->
                    <h3><?php echo htmlspecialchars($melhoria['titulo']); ?></h3>
                    <p class="categoria">Categoria: <?php echo htmlspecialchars($melhoria['categoria']); ?></p>
                    
                    <!-- descrição -->
                    <p class="descricao"><?php echo nl2br(htmlspecialchars($melhoria['descricao'])); ?></p>
                    
                    <!-- autor, votos e botão de votar -->
                    <div class="melhoria-footer">
                        <span>Por: <?php echo htmlspecialchars($melhoria['autor']); ?></span>
                        <span>Votos: <?php echo $melhoria['votos']; ?></span>
                        <form method="POST" action="votar.php" class="form-voto">
                            <input type="hidden" name="id_melhoria" value="<?php echo $melhoria['id']; ?>">
                            <button type="submit" class="btn-votar">👍 Votar</button>
                        </form>
                    </div>

                    <!-- comentários de cada melhoria -->
                    <div class="comentarios">
                        <h4>Comentários</h4>
                        <?php
                        // todos os comentários da melhoria selecionada
                        $q_comentarios = "SELECT * FROM comentarios WHERE id_melhoria = {$melhoria['id']} ORDER BY data_comentario DESC";
                        $comentarios = mysqli_query($con, $q_comentarios);
                        while ($comentario = mysqli_fetch_assoc($comentarios)):
                        ?>
                            <!-- comentário -->
                            <div class="comentario">
                                <p><?php echo htmlspecialchars($comentario['comentario']); ?></p>
                                <small>Por: <?php echo htmlspecialchars($comentario['autor']); ?></small>
                            </div>
                        <?php endwhile; ?>
                        
                        <!-- novo comentário -->
                        <form method="POST" action="comentar.php" class="form-comentario">
                            <input type="hidden" name="id_melhoria" value="<?php echo $melhoria['id']; ?>">
                            <div class="form-group">
                                <input type="text" name="autor" placeholder="Seu nome" required>
                            </div>
                            <div class="form-group">
                                <textarea name="comentario" placeholder="Seu comentário" required></textarea>
                            </div>
                            <button type="submit" class="btn-comentar">Comentar</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        
        <!-- Link para voltar à página inicial -->
        <a href="index.php" class="btn-voltar">Voltar para Lista de Cidades</a>
    </div>

    <!-- JavaScript para atualizar a URL quando filtrar por categoria -->
    <script>
    function filtrarCategoria(categoria) {
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('categoria', categoria);
        window.location.href = '?' + urlParams.toString();
    }
    </script>
</body>
</html>