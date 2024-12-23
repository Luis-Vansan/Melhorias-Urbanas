<?php
require('conexao.php');

// verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // sql injection
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $estado = mysqli_real_escape_string($con, $_POST['estado']);

    // query para inserir nova cidade no banco
    $q = "INSERT INTO cidades (nome, estado) VALUES ('$nome', '$estado')";
    if (mysqli_query($con, $q)) {
        header("Location: index.php");
        exit;
    }
}

// busca estados do banco para o select
$q_estados = "SELECT * FROM estados ORDER BY nome";
$estados = mysqli_query($con, $q_estados);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cidade</title>
    
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Nova Cidade</h1>
        <!-- formulario de cadastro da cidade -->
        <form method="POST" class="form-padrao">

            <div class="form-group">
                <label for="nome">
                    <i class="fas fa-city"></i> Nome da Cidade
                </label>
                <input type="text" 
                       id="nome" 
                       name="nome" 
                       placeholder="Digite o nome da cidade"
                       required>
            </div>
            <!-- select para escolher o estado -->
            <div class="form-group">
                <label for="estado">
                    <i class="fas fa-map-marker-alt"></i> Estado
                </label>
                <select id="estado" name="estado" required class="select-estado">
                    <option value="">Selecione um estado</option>
                    <!-- mostra todos os estados -->
                    <?php while ($estado = mysqli_fetch_assoc($estados)): ?>
                        <option value="<?php echo $estado['uf']; ?>">
                            <?php echo $estado['nome']; ?> (<?php echo $estado['uf']; ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- botões de ação -->
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Cadastrar
                </button>
                <a href="index.php" class="btn-voltar">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </form>
    </div>
</body>
</html>
