<?php
require('conexao.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_melhoria = (int)$_POST['id_melhoria'];
    
    // query que incrementa o número de votos da melhoria
    $q = "UPDATE melhorias SET votos = votos + 1 WHERE id = $id_melhoria";
    mysqli_query($con, $q);
    
    // busca o ID da cidade para o redirecionamento
    $q_cidade = "SELECT id_cidade FROM melhorias WHERE id = $id_melhoria";
    $result = mysqli_query($con, $q_cidade);
    $melhoria = mysqli_fetch_assoc($result);
    
    header("Location: melhorias.php?cidade=" . $melhoria['id_cidade']);
    exit;
}
