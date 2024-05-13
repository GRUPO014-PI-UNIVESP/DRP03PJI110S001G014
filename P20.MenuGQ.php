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
    <title>Garantia de Qualidade</title>
</head>
<style>
    body          {background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke;}
    fieldset      {border-radius: 8px;}
    legend        {text-align: center;}
    .mainBox      {position: absolute;background-color: rgba(0, 0, 0, 0.5);color: whitesmoke;width: 420px;height: 560px;padding: 10px;border-radius: 10px;top: 50%;left: 50%;transform: translate(-50%,-50%);text-align: center;}
    .seletor      {width: 95%;border: solid 1px dodgerblue ;padding: 7px;border-radius: 6px;color: whitesmoke;font-size: 15px;background-color: dodgerblue;transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;}
    .seletor:hover{background-color: aqua;color: black;transform: scale(1.1)}
    .sair         {width: 95%;border: solid 1px crimson ;padding: 6px;border-radius: 6px;font-size: 18px;color: whitesmoke;background-color: crimson;transition: background-color 0.5s ease, color 0.5s ease, transform 0.5s ease;}
    .sair:hover   {background-color: lightpink;color: black;transform: scale(1.1)}
</style>
<body>
    <div class="mainBox">
        <fieldset>
            <legend>Atividades do Laboratório</legend>
                <br>
                <button class="seletor"
                    onclick="location.href='P21.EntradaOrdemServico.php'">Abertura de Ordem de Serviço</button><br><br>
                <button class="seletor" 
                    onclick="location.href='P31.RegistroAnalise.php'">Registro de Análises</button><br><br>
                <button class="seletor"
                    onclick="location.href='P41.ReposicaoEstoque.php'">Reposição do Estoque de Reagentes</button><br><br>
                <button class="seletor"
                    onclick="location.href='P51.RelatorioGQ.php'">Listas e Relatórios</button><br><br>
                <button class="seletor"
                    onclick="location.href='P05.SenhaNova.php'">Alterar Senha de Usuário</button><br><br>
                <button class="seletor"
                    onclick="location.href='P71.CadastroNovoReagente.php'">Cadastro de Novo Reagente</button><br><br>
                <button class="seletor"
                    onclick="location.href='P61.CadastroAmostra.php'">Cadastro de Novas Amostras</button><br><br>
                <button class="seletor"
                    onclick="location.href='P81.RetiradaEstoque.php'">Retirada de Reagentes do Estoque</button><br><br>
                <button class="sair"
                    onclick="location.href='P03.LogOut.php'">Sair</button><br><br>
        </fieldset>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>