<<<<<<< HEAD
<?php
// Inclui arquivo de conexão com o banco
require('conexao.php');

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Converte o ID da melhoria para inteiro para garantir segurança
    $id_melhoria = (int)$_POST['id_melhoria'];
    
    // Escapa caracteres especiais para prevenir SQL Injection
    $autor = mysqli_real_escape_string($con, $_POST['autor']);
    $comentario = mysqli_real_escape_string($con, $_POST['comentario']);
    
    // Query para inserir o novo comentário no banco
    $q = "INSERT INTO comentarios (id_melhoria, autor, comentario) VALUES ($id_melhoria, '$autor', '$comentario')";
    mysqli_query($con, $q);
    
    // Redireciona de volta para a página anterior usando HTTP_REFERER
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
=======
<?php
require('conexao.php');

// verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_melhoria = (int)$_POST['id_melhoria'];
    
    // sql injection
    $autor = mysqli_real_escape_string($con, $_POST['autor']);
    $comentario = mysqli_real_escape_string($con, $_POST['comentario']);
    
    // query para inserir o novo comentário no banco
    $q = "INSERT INTO comentarios (id_melhoria, autor, comentario) VALUES ($id_melhoria, '$autor', '$comentario')";
    mysqli_query($con, $q);
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
>>>>>>> 3c21029258e347876a8c1c12aac5475c872dbaf8
