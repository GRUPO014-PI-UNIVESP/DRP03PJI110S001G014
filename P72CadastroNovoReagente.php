<?php
    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    include('P01ConectDB.php');
    
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
    $alerta  = '';
    $sucesso = '';
    if(isset($_POST['codReag'])){
        $codReag = $conectDB->real_escape_string(strtoupper($_POST['codReag']));
        $_SESSION['codReag'] = $codReag;

        $sql_conx  = "SELECT * FROM reagentes_estoque WHERE CODIGO_REAGENTE = '$codReag'";
        $resultado = $conectDB->query($sql_conx) or die('Falha na execução do código SQL  "<a href="index.php">Entrar</a>"');
        $busca     = $resultado->fetch_assoc();

        if(mysqli_num_rows($resultado) > 0){
            header('Location: P79Mensagem.php');      
        }
    }

    if(isset($_POST['submit'])){

        $mkrReag = $conectDB->real_escape_string(strtoupper($_POST['mkrReag']));
        $dscReag = $conectDB->real_escape_string(strtoupper($_POST['dscReag']));
        $embReag = $conectDB->real_escape_string(strtoupper($_POST['embReag']));
        $ctdReag = $conectDB->real_escape_string($_POST['ctdReag']);
        $uniReag = $conectDB->real_escape_string(strtolower($_POST['uniReag']));
        $cotaSgr = $conectDB->real_escape_string($_POST['cotaSgr']);
        $fispqDc = $conectDB->real_escape_string($_POST['fispqDc']);
        $nLote   = $conectDB->real_escape_string(strtoupper($_POST['nLote']));
        $notaFis = $conectDB->real_escape_string($_POST['notaFis']);
        $dEntra  = $conectDB->real_escape_string($_POST['dEntra']);
        $dValid  = $conectDB->real_escape_string($_POST['dValid']);
        $qLote   = $conectDB->real_escape_string($_POST['qLote']);
        $respons = $_SESSION['nomeUser'];

        $cdREAG = mysqli_query($conectDB, "INSERT INTO reagentes_estoque(CODIGO_REAGENTE, DESCR_REAGENTE, MARCA_REAGENTE,
                                EMBALAGEM, CONTEUDO_REAGENTE, COTA_LIMITE, UNIDADE, QTDE_ESTOQUE, FISPQ)
                    VALUES ('$codReag', '$dscReag', '$mkrReag', '$embReag', '$ctdReag', '$cotaSgr', '$uniReag', '$qLote', '$fispqDc')");

        $reposi = mysqli_query($conectDB, "INSERT INTO reagentes_lotes(DATA_ENTRADA, CODIGO_REAGENTE, DESCR_REAGENTE, NUMERO_LOTE,
                                DATA_VALI, QTDE_LOTE, UNIDADE, NF_REAGENTE, RESPONSAVEL)
                    VALUES ('$dEntra', '$codReag', '$dscReag', '$nLote', '$dValid', '$qLote', '$uniReag', '$notaFis', '$respons')");
            
        header('Location: P71CadastroNovoReagente.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GQ | Laboratório</title>
</head>
<style>
    body{background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke;font-size: 13px;}
    fieldset{border-radius: 8px;border-color: whitesmoke;}
    legend{text-align: center;font-size: 18px;}
    .mainBox{background-color: rgba(0, 0, 0, 0.5);position: absolute;width: 700px;height: 520px;top: 50%;left: 50%;transform: translate(-50%, -50%);padding: 10px;border-radius: 10px;}
    .box1esq{background-color: none;width: 200px;height: 35px;padding: 5px;float: left;}
    .box1dir{background-color: none;width: 435px;height: 35px;padding: 5px;float: left;}
    .box2esq{background-color: none;width: 650px;height: 35px;padding: 5px;float: left;}
    .box3esq{background-color: none;width: 210px;height: 35px;padding: 5px;float: left;}
    .box3mid{background-color: none;width: 210px;height: 35px;padding: 5px;float: left;}
    .box3dir{background-color: none;width: 200px;height: 35px;padding: 5px;float: left;}
    .box4esq{background-color: none;width: 210px;height: 35px;padding: 5px;float: left;}
    .box4dir{background-color: none;width: 425px;height: 40px;padding: 5px;float: left;}
    .box5esq{background-color: none;width: 310px;height: 35px;padding: 5px;float: left;}
    .box5dir{background-color: none;width: 300px;height: 35px;padding: 5px;float: right;}
    .box6esq{background-color: none;width: 310px;height: 35px;padding: 5px;float: left;}
    .box6dir{background-color: none;width: 300px;height: 35px;padding: 5px;float: right;}
    .box7esq{background-color: none;width: 300px;height: 50px;padding: 5px;float: left;}
    .box7dir{background-color: none;width: 300px;height: 80px;padding: 5px;float: left;}
    .box8esq{background-color: none;width: 300px;height: 30px;padding: 5px;float: left;}
    .box8dir{background-color: none;width: 300px;height: 30px;padding: 5px;float: left;}
    .inputBox{position: relative;}
    .inputUser{background: none;border: none;border-bottom: 1px solid lightsteelblue;outline: none;color: white;font-size: 13px;width: 98%;letter-spacing: 2px;}
    .labelInput{position: absolute;top: 0px;left: 0px;pointer-events: none;transition: .5s;}
    .inputUser:focus ~ .labelInput,
    .inputUser:valid ~ .labelInput{top: -10px;font-size: 10px;color: white;}
    .b2{background-color: dodgerblue;color:whitesmoke;width: 40%;height: 33px;font-size: 13px;cursor: pointer;outline: none;padding: 4px;float: left;}
    #botao:hover{background-color: crimson;}
    #datas{background-color: rgba(0, 0, 0, 0.2);color: whitesmoke;border: none;padding: 8px;border-radius: 10px;outline: none;font-size: 15px;}
    #submit{background-color: dodgerblue;width: 100%;border: none;padding: 10px;color: white;font-size: 14px;cursor: pointer;border-radius: 10px;float: right;}
    #submit:hover{background-color: darkblue;}
</style>
<body>
    <p style="text-align: center; color: red;"><?php echo '<br>'; echo $alerta ?></p>
    <div class="mainBox">
        <form action="" method="POST">
            <fieldset>
                <legend>Cadastro - Dados do Novo Reagente</legend>
                <br>
                <div class="box1esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="codReag" name="codReag" style="text-transform: uppercase; text-align:center" value="<?php echo $codReag ?>">
                        <label class="labelInput" for="codReag">Codigo do Reagente</label>
                    </div>
                </div>
                <div class="box1dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="mkrReag" name="mkrReag" style="text-transform: uppercase" autofocus required>
                        <label class="labelInput" for="mkrReag">Marca/Fornecedor</label>
                    </div>
                </div>               
                <div class="box2esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="dscReag" name="dscReag" style="text-transform: uppercase" required>
                        <label class="labelInput" for="dscReag">Descrição do Produto</label>
                    </div>
                </div>                 
                <div class="box3esq">
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="embReag" name="embReag" style="text-transform: uppercase">
                        <label class="labelInput" for="embReag">Embalagem</label>
                    </div>
                </div> 
                <div class="box3mid">
                    <div class="inputBox">
                    <input class="inputUser" type="number" id="ctdReag" name="ctdReag" required>
                        <label class="labelInput" for="ctdReag">Conteúdo Líquido</label>
                    </div>
                </div> 
                <div class="box3dir">
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="uniReag" name="uniReag" style="text-transform: lowercase"required>
                        <label class="labelInput" for="uniReag">Unidade</label>
                    </div>
                </div> 
                <div class="box4esq">
                <div class="inputBox">
                    <input class="inputUser" type="number" id="cotaSgr" name="cotaSgr" required>
                        <label class="labelInput" for="cotaSgr">Cota de Segurança</label>
                    </div>
                </div> 
                <div class="box4dir">
                    <div class="inputBox">
                    <input class="inputUser" type="file" id="fispqDc" name="fispqDc">
                        <label class="labelInput" for="fispqDc">Documentação FISPQ</label>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Dados do Lote</legend>
                <br>
                <div class="box5esq">
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="nLote" name="nLote" style="text-transform: uppercase" required>
                        <label class="labelInput" for="nLote">No. do Lote</label>
                    </div>
                </div> 
                <div class="box5dir">
                    <label style="font-size:13px;"for="dEntra">Data de Entrada:</label>
                    <input type="date" name="dEntra" id="datas" required>
                </div> 
                <div class="box6esq">
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="notaFis" name="notaFis" style="text-transform: uppercase">
                        <label class="labelInput" for="notaFis">Nota Fical</label>
                    </div>
                </div> 
                <div class="box6dir">
                <label style="font-size:13px;"for="dValid">Validade............:</label>
                        <input type="date" name="dValid" id="datas" required>
                </div> 
                <div class="box7esq">
                    <br>
                    <div class="inputBox">
                    <input class="inputUser" type="number" id="qLote" name="qLote" required>
                        <label class="labelInput" for="qLote">Quantidade do Lote</label>
                    </div>
                </div>
                <div class="box7dir">
                    <br><br><br>
                <input type="submit" id="submit" name="submit" value="Confirmar">
                </div>
                <div class="box8esq">
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">
                    <input class="b2" type="reset" value="Sair" id="botao" onclick="location.href='P03LogOut.php'">
                    <p style="text-align: center, color: red;"> <?php echo $sucesso ?> </p>
                </div>
                <div class="box8dir">
                    <p style="text-align: center, color: red;"> <?php echo $sucesso ?> </p>
                </div>
            </fieldset>
        </form>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>