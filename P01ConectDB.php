<?php
    // P01.ConectDB.php
    // Faz a conexão com o banco de dados

    //Rotina de inicialização de conexão com o banco de dados MySQL
    $dbHost = 'us-cluster-east-01.k8s.cleardb.net';
    $dbUser = 'b42ff6e02fff94';
    $dbPass = '2beb86ba';
    $dbBase = 'heroku_4432971c05417e6';

    //Variável de conexão
    $conectDB = new mysqli($dbHost, $dbUser, $dbPass, $dbBase);
    //verificação da conexão com banco de dados
    if($conectDB->error){
        die('Falha na conexão com o banco de dados!');
    }

?>