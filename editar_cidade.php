<?php
// Inclui arquivo de conexão com o banco
require('conexao.php');

// Pega o ID da cidade da URL e converte para inteiro (segurança)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapa caracteres especiais para prevenir SQL Injection
    $nome = mysqli_real_escape_string($con, $_POST['nome']);
    $estado = mysqli_real_escape_string($con, $_POST['estado']);
    
    // Query para atualizar os dados da cidade
    $q = "UPDATE cidades SET nome = '$nome', estado = '$estado' WHERE id = $id";
    if (mysqli_query($con, $q)) {
        // Se atualizou com sucesso, redireciona para página inicial
        header("Location: index.php");
        exit;
    }
}

// Busca os dados atuais da cidade
$q = "SELECT * FROM cidades WHERE id = $id";
$cidade = mysqli_fetch_assoc(mysqli_query($con, $q));

// Busca lista de estados para o select
$q_estados = "SELECT * FROM estados ORDER BY nome";
$estados = mysqli_query($con, $q_estados);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <!-- Configurações básicas da página -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cidade</title>
    <!-- Carregamento dos arquivos CSS e fontes -->
    <link rel="stylesheet" href="style.css?v=1">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Cabeçalho da página -->
        <div class="edit-header">
            <h1>Editar Cidade</h1>
            <p class="subtitle">Atualize as informações da cidade</p>
        </div>
        
        <div class="form-container">
            <!-- Formulário de edição -->
            <form method="POST" class="form-padrao">
                <!-- Campo para nome da cidade -->
                <div class="form-group">
                    <label for="nome">
                        <i class="fas fa-city"></i> Nome da Cidade
                    </label>
                    <input type="text" 
                           id="nome" 
                           name="nome" 
                           value="<?php echo htmlspecialchars($cidade['nome']); ?>" 
                           placeholder="Digite o nome da cidade"
                           required>
                </div>
                
                <!-- Select para escolher o estado -->
                <div class="form-group">
                    <label for="estado">
                        <i class="fas fa-map-marker-alt"></i> Estado
                    </label>
                    <select id="estado" name="estado" required class="select-estado">
                        <option value="">Selecione um estado</option>
                        <?php while ($estado = mysqli_fetch_assoc($estados)): ?>
                            <option value="<?php echo $estado['uf']; ?>" 
                                    <?php echo $cidade['estado'] == $estado['uf'] ? 'selected' : ''; ?>>
                                <?php echo $estado['nome']; ?> (<?php echo $estado['uf']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- Botões de ação do formulário -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                    <a href="index.php" class="btn-voltar">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </form>

            <!-- Zona de perigo - área para remoção da cidade -->
            <div class="danger-zone">
                <div class="danger-header">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Zona de Perigo</h3>
                </div>
                <p>Atenção: A remoção de uma cidade é permanente e não pode ser desfeita.</p>
                <!-- Formulário de remoção -->
                <form method="POST" 
                      action="remover_cidade.php" 
                      class="form-delete" 
                      onsubmit="return confirm('Tem certeza que deseja remover esta cidade? Esta ação não pode ser desfeita.');">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Remover Cidade
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>