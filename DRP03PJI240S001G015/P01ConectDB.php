<?php

    //Rotina de inicialização de conexão com o banco de dados MySQL
    $dbHost = 'localHost';
    $dbUser = 'root';
    $dbPass = '';
    $dbBase = 'drp03pji240s001g015';
    $port   = 3306;

    //Variável de conexão
    $conectDB = new mysqli($dbHost, $dbUser, $dbPass, $dbBase);
    
    //verificação da conexão com banco de dados
        if($conectDB->error){
        die('Falha na conexão com o banco de dados!');}

    //try{
        // conexão com porta
        // $conectDB = new PDO("mysql:host = $dbHost; port = $port; dbname=" . $dbBase, $dbUser, $dbPass);

        // conexão sem porta
    //    $conectDB = new PDO("mysql:host = $dbHost; dbname = " . $dbBase, $dbUser, $dbPass);
    //} catch(PDOException $err){
    //    die("Erro de Conexão" . $err->getMessage());
    //}