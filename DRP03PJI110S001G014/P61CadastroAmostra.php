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
    <title>GQ | Amostras</title>
</head>
<style>
    body{background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke;font-size: 12px;}
    fieldset{border-radius: 4px; padding: 3px;}
    legend{text-align: center; font-size: 15px;}

    .mainBox{position: absolute; background-color: rgba(0, 0, 0, 0.5); width: 90%; height: 40%; top: 50%; left: 50%; transform: translate(-50%, -50%); border-radius: 10px;}
    .linha1esq{width: 35%; height: 35px; float: left; padding: 3px;}
    .linha1dir{width: 62%; height: 35px; float: left; padding: 3px;}

    .linha2esq{width: 98%; height: 35px; float: left; padding: 3px;}

    .linha3esq{width: 52%; height: 35px; float: left; padding: 3px;}
    .linha3mid{width: 27%; height: 35px; float: left; padding: 3px;}
    .linha3dir{width: 17%; height: 35px; float: left; padding: 3px;}

    .linha4esq{width: 52%; height: 35px; float: left; padding: 3px;}
    .linha4mid{width: 27%; height: 35px; float: left; padding: 3px;}
    .linha4dir{width: 17%; height: 35px; float: left; padding: 3px;}

    .linhabotao{width: 95%; height: 55px; float: right; padding: 3px;}

    .inputBox  {position:relative;}
    .inputUser {background:none; border:none; border-bottom:1px solid lightsteelblue; outline:none; color:white; font-size:13px; width:98%; letter-spacing:2px;}
    .labelInput{position:absolute; top:0px; left:0px; pointer-events:none; transition:.5s;}
    .inputUser:focus ~ .labelInput,
    .inputUser:valid ~ .labelInput{top:-12px; font-size:10px; color:bisque;}

    #submit      {background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px; cursor:pointer; border-radius:10px;}
    #submit:hover{background-color: darkblue;}

    .b2      {background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px; cursor:pointer; border-radius:10px;}
    .b2:hover{background-color: crimson;}
</style>
<body>
    <div class="mainBox">
        <form action="P62CadastroAmostra.php" method="POST">
            <fieldset>
                <legend>Cadastro de Novas Amostras de Análise</legend>
                <div class="linha1esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="codAmostra" name="codAmostra" style="text-align:center; text-transform: uppercase" onchange="this.form.submit()" required>
                        <label class="labelInput" for="codAmostra">Código da Amostra</label>
                    </div>
                </div>
                <div class="linha1dir">

                </div>
                <div class="linha2esq">

                </div>
                <div class="linha3esq">

                </div>
                <div class="linha3mid">

                </div>
                <div class="linha3dir">

                </div>
                <div class="linha4esq">
                    <br>

                </div>
                <div class="linha4mid">
                    <br>

                </div>
                <div class="linha4dir">
                    <br>

                </div>
                <div class="linhabotao">
                    <br>
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">
                    <input class="b2" type="reset" value="Sair"   id="botao" onclick="location.href='P03LogOut.php'">
                    <br>
                </div>
                <br>
            </fieldset>
        </form>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div> 
</body>
</html>