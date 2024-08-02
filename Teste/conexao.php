<?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "pesquisar";
  $port = 3306;

  //$con = new mysqli($host, $user, $pass, $dbname);

  //if($con->error){
  //  dir('Falha na conexão!');
  //}

  try{
    //conexão com porta
    //$conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbname, $user, $pass);

    //conexão sem porta
    $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);

  } catch(PDOException $err){
    die("erro de conexão" . $err->getMessage());
  }
