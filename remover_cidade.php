<?php
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    
    // Primeiro remove todas as melhorias associadas à cidade
    // Isso é necessário para manter a integridade referencial do banco
    mysqli_query($con, "DELETE FROM melhorias WHERE id_cidade = $id");
    
    // Depois remove a cidade
    mysqli_query($con, "DELETE FROM cidades WHERE id = $id");
    
    // Redireciona para a página inicial
    header("Location: index.php");
    exit;
} 