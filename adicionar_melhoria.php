<?php
require('conexao.php');

//pega o ID da cidade da URL, convertendo para inteiro por segurança
$id_cidade = isset($_GET['cidade']) ? (int)$_GET['cidade'] : 0;

// verifica se foi enviado via post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // previne sqlinjection
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($con, $_POST['descricao']);
    $categoria = mysqli_real_escape_string($con, $_POST['categoria']);
    $autor = mysqli_real_escape_string($con, $_POST['autor']);

    // query para inserir nova melhoria no banco
    $q = "INSERT INTO melhorias (id_cidade, titulo, descricao, categoria, autor) 
          VALUES ($id_cidade, '$titulo', '$descricao', '$categoria', '$autor')";
    
    // se funcionou, redireciona para pagina de melhorias
    if (mysqli_query($con, $q)) {
        header("Location: melhorias.php?cidade=$id_cidade");
        exit;
    }
}

// dados da cidade selecionada
$q_cidade = "SELECT * FROM cidades WHERE id = $id_cidade";
$cidade = mysqli_fetch_assoc(mysqli_query($con, $q_cidade));
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerir Melhoria</title>
    
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">

        <h1>Sugerir Melhoria para <?php echo htmlspecialchars($cidade['nome']); ?></h1>
        
        <!-- formulario de adicionar melhoria -->
        <form method="POST" class="form-padrao">

            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            
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
            
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="6" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="autor">Seu Nome:</label>
                <input type="text" id="autor" name="autor" required>
            </div>
            
            <!-- botões de ação -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">Enviar Sugestão</button>
                <a href="melhorias.php?cidade=<?php echo $id_cidade; ?>" class="btn-voltar">Voltar</a>
            </div>
        </form>
    </div>
</body>
</html>
