<?php
// Inclui arquivo de conexão com o banco
require('conexao.php');

// Pega o ID da cidade da URL, convertendo para inteiro por segurança
$id_cidade = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 0;

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapa caracteres especiais para prevenir SQL Injection
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria']);
    $autor = mysqli_real_escape_string($con, $_POST['autor']);

    // Query para inserir nova melhoria no banco
    $q = "INSERT INTO melhorias (id_cidade, titulo, descricao, categoria, autor) 
          VALUES ($id_cidade, '$titulo', '$descricao', '$categoria', '$autor')";
    
    // Se inseriu com sucesso, redireciona para página de melhorias
    if (mysqli_query($con, $q)) {
        header("Location: melhorias.php?cidade=$id_cidade");
        exit;
    }
}

// Busca dados da cidade selecionada
$q_cidade = "SELECT * FROM cidades WHERE id = $id_cidade";
$cidade = mysqli_fetch_assoc(mysqli_query($con, $q_cidade));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Meta tags e configurações básicas -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerir Melhoria</title>
    
    <!-- CSS e fontes -->
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Título com nome da cidade -->
        <h1>Sugerir Melhoria para <?php echo htmlspecialchars($cidade['nome']); ?></h1>
        
        <!-- Formulário para adicionar melhoria -->
        <form method="POST" class="form-padrao">
            <!-- Campo do título -->
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
            <!-- Select de categorias -->
            <div class="form-group">
                <label for="categoria">Categoria:</label>
                <select id="categoria" name="categoria" required>
                    <option value="Infraestrutura">Infraestrutura</option>
                    <option value="Saúde">Saúde</option>
                    <option value="Educação">Educação</option>
                    <option value="Segurança">Segurança</option>
                    <option value="Transporte">Transporte</option>
                    <option value="Outros">Outros</option>
                </select>
            </div>
            
            <!-- Campo da descrição -->
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="6" required></textarea>
            </div>
            
            <!-- Campo do nome do autor -->
            <div class="form-group">
                <label for="autor">Seu Nome:</label>
                <input type="text" id="autor" name="autor" required>
            </div>
            
            <!-- Botões de ação -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">Enviar Sugestão</button>
                <a href="melhorias.php?cidade=<?php echo $id_cidade; ?>" class="btn-voltar">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
