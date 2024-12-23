<?php
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    
    //remove todas as melhorias associadas à cidade
    mysqli_query($con, "DELETE FROM melhorias WHERE id_cidade = $id");
    
    //remove a cidade
    mysqli_query($con, "DELETE FROM cidades WHERE id = $id");
    
    header("Location: index.php");
    exit;
} 