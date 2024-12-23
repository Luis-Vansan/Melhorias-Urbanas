<?php
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    
    // Primeiro, remover os comentários relacionados
    $sql_comentarios = "DELETE FROM comentarios WHERE id_melhoria IN (SELECT id FROM melhorias WHERE id_cidade = $id)";
    mysqli_query($con, $sql_comentarios);
    
    // Depois, remover as melhorias relacionadas
    $sql_melhorias = "DELETE FROM melhorias WHERE id_cidade = $id";
    mysqli_query($con, $sql_melhorias);
    
    // Por último, remover a cidade
    $sql_cidade = "DELETE FROM cidades WHERE id = $id";
    mysqli_query($con, $sql_cidade);
    
    // Redireciona para a página inicial
    header("Location: index.php");
    exit;
} 