<?php
    // P02Security.php
    // Faz o bloqueio de acesso sem que seja pela pagina inicial index.php

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){
        session_start();
    }
    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
        die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');    
    }   
?>