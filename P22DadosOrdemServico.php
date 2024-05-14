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

    if(isset($_POST['submit'])){

        $sitAmostra    = 'AGUARDANDO';
        $codAmostra    = strtoupper($_SESSION['codAmostra']);
        $tipAmostra    = strtoupper($_SESSION['tipAmostra']);
        $dscAmostra    = strtoupper($_SESSION['dscAmostra']);
        $dataOrdem     =            $_POST['dOrdem'];
        $dataPrazo     =            $_POST['dPrazo'];
        $loteAmostra   = strtoupper($_POST['loteAmostra']);
        $ttlAmostra    =            $_POST['ttlAmostra'];
        $qtdeAmostra   =            $_POST['qtdeAmostra'];
        $respons       = $_SESSION['nomeUser'];

        $sql_verifica    = "SELECT * FROM ordem_servico WHERE NUMERO_LOTE = '$loteAmostra'";
        $verifica        = $conectDB->query($sql_verifica);
        $result_verifica = $verifica->fetch_assoc();
        $registros       = mysqli_num_rows($verifica);

        if($registros > 0){
            echo 'Este No.de Lote já existe na lista de Ordem de Serviço, favor verificar   "<a href="P21EntradaOrdemServico.php">Entrar</a>"';
        } else{
            $cadastra  = mysqli_query($conectDB, "INSERT INTO ordem_servico (TIPO_ANALISE, CODIGO_AMOSTRA, DESCRICAO_AMOSTRA,
                                        DATA_ORDEM, DATA_PRAZO, NUMERO_LOTE, QTDE_LOTE, QTDE_AMOSTRA, SITUACAO, RESPONSAVEL)
                                VALUES ('$tipAmostra', '$codAmostra', '$dscAmostra', '$dataOrdem', '$dataPrazo', 
                                        '$loteAmostra', '$ttlAmostra', '$qtdeAmostra','$sitAmostra', '$respons')");

            header('Location: P21EntradaOrdemServico.php');
        }
    
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
    <br><br>
        <div class="mainBox">
            <fieldset>
                <legend>Ordem de Serviço para Análise de Qualidade</legend>
                <br>
                <div class="box1esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="codAmostra" name="codAmostra" value="<?php echo $_SESSION['codAmostra'] ?>">
                        <label class="labelInput" for="codAmostra">Código da Amostra</label><br><br>
                    </div>
                </div>
                <div class="box1dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="tipAmostra" name="codAmostra" value="<?php echo $_SESSION['tipAmostra'] ?>">
                        <label class="labelINput" for="tipAmostra">Tipo da Amostra</label><br><br>
                    </div>
                </div>
                <div class="box1inf">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="dscAmostra" name="dscAmostra" value="<?php echo $_SESSION['dscAmostra'] ?>">
                        <label class="labelInput" for="dscAmostra">Descrição da Amostra</label><br><br>
                    </div>
                </div>
            </fieldset>
        <br>
        <form action="" method="POST">
            <fieldset>
                <div class="box2esq">
                        <label for="dOrdem">Data da Ordem</label>
                        <input type="date" id="datas" name="dOrdem" required>
                </div>
                <div class="box2dir">
                        <label for="dPrazo">Prazo de Conclusão</label>
                        <input type="date" id="datas" name="dPrazo" required>
                </div>
                <div class="box3esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="loteAmostra" name="loteAmostra" style="text-transform: uppercase" required>
                        <label class="labelInput" for="loteAmostra">No.Lote da Amostra</label><br><br>
                    </div>
                </div>
                <div class="box3mid">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="number" id="ttlAmostra" name="ttlAmostra" required>
                        <label class="labelInput" for="ttlAmostra">Total do Lote(kg)</label><br><br>
                    </div>
                </div> 
                <div class="box3dir">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="number" id="qtdeAmostra" name="qtdeAmostra" required>
                        <label class="labelInput" for="qtdeAmostra">Qtde.de Amostras</label><br><br>
                    </div>
                </div>
                <div class="box4esq">
                    <br>
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">
                    <input class="b2" type="reset" value="Sair"   id="botao" onclick="location.href='P03LogOut.php'">
                </div>
                <div class="box4dir">
                    <br>
                    <input type="submit" id="submit" name="submit" value="Confirmar">
                </div>
            </fieldset>
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
        </form>
        </div>
    <input type="button" value="voltar" onclick="location.href='P20MenuGQ.php'">
</body>
</html>