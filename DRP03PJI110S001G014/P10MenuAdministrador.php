<?php
    include('P01ConectDB.php');
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
    <title>Seletor de Ambiente</title>
</head>
<style>
body          {background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; color: whitesmoke;}
.mainBox      {background: none; color: whitesmoke; position: absolute; width: 650px; height: 450px; top: 50%; left: 50%; transform: translate(-50%,-50%);}
.esquerdaSup  {background: none; color: whitesmoke; width: 300px; height: 200px; float: left;}
.direitaSup   {background: none; color: whitesmoke; width: 300px; height: 200px; float: right;}
.espaco       {background: none; width: 650px; height: 50px; float: left}
.esquerdaInf  {background: none; color: whitesmoke; width: 300px; height: 200px; float: left;}
.direitaInf   {background: none; color: whitesmoke; width: 300px; height: 200px; float: right;}
.saida        {background: none; color: whitesmoke; width: 100%; height: 100px; float: left; text-align: center;}
.seletor      {width: 100%; height: 100%; padding: 6px; outline: none; border-radius: 10px; color: whitesmoke; font-size: 30px; background-color: midnightblue; transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;}
.seletor:hover{background-color: blue; color: whitesmoke; transform: scale(1.2); cursor: pointer;}
.sair         {width: 180px; height: 40px; border: solid 1px rgb(211, 14, 70) ; padding: 6px; border-radius: 20px; color: whitesmoke; font-size: 18px; background-color: rgb(211, 14, 70); transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;}
.sair:hover   {background-color: red; color: whitesmoke; transform: scale(1.2); cursor: pointer;}
</style>
<body>   
    <div class="mainBox">
        <div class="esquerdaSup">
            <button class="seletor" onclick="location.href='P11MenuAdmin.php'">Administração</button><br><br>
        </div>
        <div class="direitaSup">
            <button class="seletor" onclick="location.href='P20MenuGQ.php'">Garantia de Qualidade</button><br><br>
        </div>
        <div class="espaco">
        </div>
        <div class="esquerdaInf">
            <button class="seletor" onclick="location.href='P91MenuProd.php'">Produção</button><br><br>
        </div>
        <div class="direitaInf">
            <button class="seletor" onclick="location.href='P90MenuLog.php'">Logística</button><br><br>
        </div>
        <div class="saida">
            <br><br>
            <button class="sair" onclick="location.href='P03LogOut.php'">Sair do Sistema</button><br><br>
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
        </div>
    </div>
    <br>
</body>
</html>