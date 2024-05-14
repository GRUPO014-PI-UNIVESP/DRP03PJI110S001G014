<?php
    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    include('P01ConectDB.php');
    
    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}
    
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
    <title>Administração | Funcionários</title>
</head>
<style>
body{background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke; font-size: 12px;}
fieldset{border-radius: 8px;border-color: whitesmoke;}
.mainBox{position: absolute; padding: 10px; border-radius: 10px; background-color: rgb(0, 0, 0, 0.5); width: 92%; height: 75%; top: 50%; left: 50%; transform: translate(-50%, -50%);}
.box1esq{width: 32%; height: 35px;  padding: 5px; float: left;}
.box1dir{width: 65%; height: 35px;  padding: 5px; float: left;}
.box2esq{width: 32%; height: 35px;  padding: 5px; float: left;}
.box2dir{width: 65%; height: 35px;  padding: 5px; float: left;}
.box3esq{width: 10%; height: 35px;  padding: 5px; float: left;}
.box3miL{width: 10%; height: 35px;  padding: 5px; float: left;}
.box3miR{width: 38%; height: 35px;  padding: 5px; float: left;}
.box3dir{width: 37%; height: 35px;  padding: 5px; float: left;}
.box4esq{width: 60%; height: 35px;  padding: 5px; float: left;}
.box4dir{width: 37%; height: 35px;  padding: 5px; float: left;}
.box5esq{width: 150px; height: 200px; padding: 5px; float: left;}
.box5spc{width: 010px; height: 200px; padding: 5px; float: left;}
.box5mid{width: 250px; height: 200px; padding: 5px; float: left;}
.box5dir{width: 250px; height: 200px; padding: 5px; float: left;}
.box5View{background-color: rgba(0, 0, 0, 0.2); width: 280px; height: 200px; padding: 5px; float: left;}
.box6esq{width: 850px; height: 80px; padding: 5px; float: left;}
.boxBotoes{width: 380px; height: 40px; padding: 5px; float: left;}
.boxSub{background: none; width: 200px; height: 40px; padding: 5px; float: right;}
.inputBox{position: relative;}
.inputUser{background: none; border: none; border-bottom: 1px solid lightsteelblue; outline: none; color: white; font-size: 13px; width: 98%; letter-spacing: 2px;}
.labelInput{position: absolute; top: 0px; left: 0px; pointer-events: none; transition: .5s;}
.inputUser:focus ~ .labelInput,
.inputUser:valid ~ .labelInput{top: -10px; font-size: 10px; color: white;}
.b1{background-color: dodgerblue;color:whitesmoke; width: 90px; height: 30px; font-size: 13px; cursor: pointer; outline: none; padding: 4px;}
#select:hover{background-color: crimson;}
.b2{background-color: dodgerblue;color:whitesmoke; width: 40%; height: 33px; font-size: 13px; cursor: pointer; outline: none; padding: 4px; float: right;}
#botao:hover{background-color: crimson;}
#datas{background-color: rgba(0, 0, 0, 0.2); color: whitesmoke; border: none; padding: 8px; border-radius: 10px; outline: none; font-size: 15px;}
#submit{background-color: dodgerblue; width: 100%; border: none; padding: 10px; color: white; font-size: 14px; cursor: pointer; border-radius: 10px; float: right;}
#submit:hover{background-color: darkblue;}
</style>
<body>
    <div class="mainBox">
        <fieldset>
            <legend>Cadastro de Novo Funcionário</legend>
            <div class="box1esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" name="nascimento" id="nascimento" value="<?php echo date('d/m/Y', strtotime($_SESSION['nascFunc'])) ?>">
                        <label class="labelInput" for="nascimento" >Data de Nascimento</label>
                    </div>
                </div>
                <div class="box1dir">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" name="nome" id="nome" style="text-transform: uppercase" value="<?php echo strtoupper($_SESSION['nomeFunc']) ?>">
                        <label class="labelInput" for="nome" >Nome Completo*</label>
                    </div>
                </div>
                <div class="box2esq">
                    <p style="color:yellow; font-size:12px">Nome e data de Nascimento já constam no banco de dados...Favor verifique para continuar...</p>
                </div>
                <div class="boxBotoes">
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P11MenuAdmin.php'">
                    <input class="b2" type="reset" value="Sair" id="botao" onclick="location.href='P03LogOut.php'"> 
                </div>
        </fieldset>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>