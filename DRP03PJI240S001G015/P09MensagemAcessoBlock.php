
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensagem</title>
</head>
<style>
    body{
        background-color: rgba(25, 170, 150, 0.8);
        font-family: Arial, Helvetica, sans-serif;
        color: whitesmoke;
    }
    .aviso{
        margin-top: 30%;
        margin-left: 50%;
        text-align: center;
        font-size: 40px;
    }
</style>
<body>
    <?php
    echo '<script type="text/javascript"> 
            alert("Sua credencial não permite acessar este serviço!!!");
        </script>';
    ?>
    <button class="aviso" onclick="location.href='P11MenuAdmin.php'">Voltar</button>
</body>
</html>