<?php
    // index.php
    // Modulo incial do sistema que abre uma página web e solicita Usuário e Senha para Login
    
    // chama rotina de conexão com banco de dados
    include('P01ConectDB.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/index.css">
    <title>Home|Login</title>
</head>

<style></style>

<body>
    <!--Formulário de Login-->
    <form action="P00Login.php" method="POST">
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
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by DRP03PJI240S001G015 2024</p>
        </div>
    </form>
</body>
</html>