<?php

    // Definição das variáveis de conexão com o banco de dados
    $host = 'localhost';      // Endereço do servidor MySQL
    $user = 'root';          // Nome do usuário do banco
    $password = '';          // Senha do banco (vazia neste caso)
    $db = 'reclameaqui';     // Nome do banco de dados
    $port = 3306;            // Porta padrão do MySQL

    // Estabelece a conexão com o banco de dados usando mysqli
    $con = mysqli_connect(
        $host,      // Host
        $user,      // Usuário
        $password,  // Senha
        $db,        // Nome do banco
        $port       // Porta
    );

    // Linha comentada que pode ser usada para debug da conexão
    //var_dump($con);
