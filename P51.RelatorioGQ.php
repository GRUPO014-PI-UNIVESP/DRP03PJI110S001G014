<?php
    include('P01.ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){
        session_start();
    }
    $dia = strtotime($_SESSION['dataLogin']);
    echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
        die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');    
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GQ | Relatórios</title>
</head>
<style>
    body{background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; color: whitesmoke; font-size: 12px;}
    .mainBox{background-color: rgba(0, 0, 0, 0.5); position: absolute; width: 96%; height: 90%; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 5px;}
    .topolinha{width: 100%; height: 30px;}
    .botao{width: 19.5%; height: 35px; font-size: 14px; background-color: dodgerblue; color: whitesmoke; border-radius: 4px;}
    .botao:hover{background-color: crimson; font-size: 15px;}
</style>
<body>
    <div class="mainBox">
        <div class="topolinha">
            <input class="botao" type="button" id="" name="" value="Estoque de Reagentes"          onclick="location.href='P52.EstoqueReagentes.php'">
            <input class="botao" type="button" id="" name="" value="Lista dos Lotes de Reagentes"  onclick="location.href='P53.ListaLotes.php'">
            <input class="botao" type="button" id="" name="" value="Lista de Ordens de Serviço"    onclick="location.href='P54.ListaOrdens.php'">
            <input class="botao" type="button" id="" name="" value="Lista de Análises Concluídas"  onclick="location.href='P55.ListaConcluidos.php'">
            <input class="botao" type="button" id="" name="" value="Voltar"                        onclick="location.href='P20.MenuGQ.php'">
        </div>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>

</body>
</html>