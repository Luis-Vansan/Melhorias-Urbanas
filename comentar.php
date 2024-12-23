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
