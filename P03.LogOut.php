<?php
    // P03.LogOut.php
    // Modulo que fecha a sessão aberta pelo último usuário

    if(!isset($_SESSION)){
        session_start();
    }

    include('P01.ConectDB.php');
    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    $dOut = date('Y-m-d');
    $hOut = date('H:i:s');
    $dIN  = $_SESSION['dataLogin'];
    $hIN  = $_SESSION['horaLogin'];
    $logado = $_SESSION['nomeUser'];

    $logOut = mysqli_query($conectDB, "UPDATE registro_login SET DATA_LOGOUT = '$dOut', HORA_LOGOUT = '$hOut' 
    WHERE USUARIO_LOGADO = '$logado' AND DATA_LOGIN = '$dIN' AND HORA_LOGIN = '$hIN' ");

    //destroi todas as informações de login e fecha a sessão e volta para página de Login
    session_destroy();
    header('Location: index.php');
?>