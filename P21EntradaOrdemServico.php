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
    <title>GQ | Ordem de Serviço</title>
</head>
<style>
    body{background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke;}
    fieldset{border-radius: 8px;border-color: whitesmoke;}
    legend{text-align: center;font-size: 18px;}

    .mainBox{position: absolute;color: white;background-color: rgba(0, 0, 0, 0.5);padding: 10px;border-radius: 10px;width: 770px;height: 350px;top: 50%;left: 50%;transform: translate(-50%,-50%);}

    .box1esq{background-color: none;width: 350px;height: 35px;padding: 5px;float: left;}
    .box1dir{background-color: none;width: 350px;height: 35px;padding: 5px;float: left;}
    .box1inf{background-color: none;width: 720px;height: 35px;padding: 5px;float: left;}
    .box2esq{background-color: none;width: 320px;height: 35px;padding: 5px;float: left;}
    .box2dir{background-color: none;width: 320px;height: 35px;padding: 5px;float: left;}
    .box3esq{background-color: none;width: 230px;height: 35px;padding: 5px;float: left;}
    .box3mid{background-color: none;width: 230px;height: 35px;padding: 5px;float: left;}
    .box3dir{background-color: none;width: 230px;height: 35px;padding: 5px;float: left;}
    .box4esq{background-color: none;width: 300px;height: 40px;padding: 5px;float: left;}
    .box4dir{background-color: none;width: 300px;height: 40px;padding: 5px;float: right;}

    .inputBox{position: relative;}
    .inputUser{background: none;border: none;border-bottom: 1px solid lightsteelblue;outline: none;color: white;font-size: 13px;width: 98%;letter-spacing: 2px;}
    .labelInput{position: absolute;top: 0px;left: 0px;pointer-events: none;transition: .5s;}
    .inputUser:focus ~ .labelInput,
    .inputUser:valid ~ .labelInput{top: -10px;font-size: 10px;color: white;}
    .b2{background-color: dodgerblue;color:whitesmoke;width: 40%;height: 33px;font-size: 13px;border-radius: 7px;cursor: pointer;outline: none;padding: 4px;float: right;}

    #botao:hover{background-color: crimson;}
    #datas{background-color: rgba(0, 0, 0, 0.2);color: whitesmoke;border: none;padding: 8px;border-radius: 10px;outline: none;font-size: 15px;}
    #submit{background-color: dodgerblue;width: 120;border: none;padding: 8px;color: white;font-size: 14px;cursor: pointer;border-radius: 10px;}
    #submit:hover{background-color: darkblue;}
</style>
<body>
    <br>
    <form action="" method="POST">
        <div class="mainBox">
            <fieldset>
                <legend>Ordem de Serviço para Análise de Qualidade</legend>
                <div class="box1esq">
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="codAmostra" name="codAmostra" style="text-align:center; text-transform: uppercase" onchange="this.form.submit()" required>
                        <label class="labelInput" for="codAmostra">Código da Amostra</label>
                    </div>
                </div>
            </fieldset>
            <br><br>
            <div class="box4dir">
                <input class="b2" type="reset" id="botao" value="voltar" onclick="location.href='P20MenuGQ.php'">
                <input class="b2" type="reset" id="botao" value="sair"   onclick="location.href='P03LogOut.php'">
            </div>
        </div>
    </form>
    <?php
    if(isset($_POST['codAmostra'])){
        $codAmostra     = strtoupper($_POST['codAmostra']);
        $sql_amostra    = "SELECT * FROM amostras WHERE CODIGO_AMOSTRA = '$codAmostra'";
        $result_busca   = $conectDB->query($sql_amostra);
        $found_amostra  = $result_busca->fetch_assoc();
        $contador       = mysqli_num_rows($result_busca);
        if($contador == 0){
            echo 'Amostra não encontrada, verifique e reinicie procedimento  "<a href="P21.EntradaOrdemServico.php">Voltar</a>"';
        } else{
            $_SESSION['codAmostra'] = $codAmostra;
            $_SESSION['dscAmostra'] = $found_amostra['DESCRICAO_AMOSTRA'];
            $_SESSION['tipAmostra'] = $found_amostra['TIPO_AMOSTRA'];

            header("Location: P22DadosOrdemServico.php");
        }
    }
    ?>
</body>
</html>