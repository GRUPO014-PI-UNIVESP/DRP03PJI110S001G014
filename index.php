<?php
    // index.php
    // Modulo incial do sistema que abre uma página web e solicita Usuário e Senha para Login
    
    // chama rotina de conexão com banco de dados
    include('P01.ConectDB.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home|Login</title>
</head>
<style>
body       {background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: whitesmoke;}
fieldset   {text-align: center; border-radius: 8px; border-color: whitesmoke;}
.LoginBox  {position: absolute; background-color: rgba(0, 0, 0, 0.5); width: 240px; height: 295px; top: 50%; left: 50%; transform: translate(-50%,-50%); color: whitesmoke; padding: 10px; border-radius: 10px;}
.boxSub    {background: none; width: 450px; height: 70px; padding: 5px; float: left;}
.inputBox  {position: relative;}
.inputUser {background: none; border: none; border-bottom: 1px solid white; outline: none; color: white; font-size: 16px; width: 98%; letter-spacing: 2px;}
.labelInput{position: absolute; top: 0px; left: 0px; pointer-events: none; transition: .5s;}

#submit      {background-color: dodgerblue; width: 98%; border: none; padding: 10px; color: white; font-size: 20px; cursor: pointer; border-radius: 10px;}
#submit:hover{background-color: darkblue;}

.inputUser:focus ~ .labelInput,
.inputUser:valid ~ .labelInput{top: -10px; font-size: 10px; color: white;}
</style>
<body>
    <form action="P00.Login.php" method="POST">
        <div class="LoginBox">
            <fieldset>
                <legend style="font-size: 25px;"><b>Login</b></legend>
                <br><br>
                <div class="inputBox">
                    <input class="inputUser" type="text" name="usuario" id="usuario" required>
                    <label class="labelInput" for="usuario" >Digite seu ID de Usuário</label>                    
                </div>
                <br><br>
                <div class="inputBox">
                    <input class="inputUser" type="password" name="senha" id="senha" required>
                    <label class="labelInput" for="senha" >Digite sua Senha (6 dígitos)</label>                    
                </div>
                <br><br><br>
                <div>
                    <input type="submit" name="submit" id="submit">
                </div>
                <br>
            </fieldset>
            <br>
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
        </div>
    </form>
</body>
</html>