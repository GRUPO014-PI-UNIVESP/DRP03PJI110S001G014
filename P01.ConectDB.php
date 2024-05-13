<?php
    // P01.ConectDB.php
    // Faz a conexão com o banco de dados

    //Rotina de inicialização de conexão com o banco de dados MySQL
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbBase = 'projetointegrador';

    //Variável de conexão
    $conectDB = new mysqli($dbHost, $dbUser, $dbPass, $dbBase);
    //verificação da conexão com banco de dados
    if($conectDB->error){
        die('Falha na conexão com o banco de dados!');
    }

?>