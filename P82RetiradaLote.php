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

    $sucesso = '';
    if(isset($_POST['submit']) && !empty($_POST['nLote'])){

        $dscReag = $_SESSION['dscReag'];
        $uniReag = $_SESSION['uniReag'];
        $nLote   = $conectDB->real_escape_string($_POST[_('nLote')]);
        $qLote   = $conectDB->real_escape_string($_POST[_('qLote')]);
        $obsv    = $conectDB->real_escape_string($_POST[_('observacao')]);
        $retira  = $_SESSION['qEstoque'] - $qLote;
        $codigo  = $_SESSION['codReag'];
        $respons = $_SESSION['nomeUser'];
        
        // Atualiza a quantidade do reagente no estoque
        $update_estoque = mysqli_query($conectDB, "UPDATE reagentes_estoque SET QTDE_ESTOQUE = '$retira' WHERE CODIGO_REAGENTE = '$codigo'");

        $sql3           = "SELECT * FROM reagentes_lotes WHERE NUMERO_LOTE = '$nLote'";
        $resultado_lote = mysqli_query($conectDB, $sql3);
        $busca2         = $resultado_lote->fetch_assoc();
        $retira_lote    = $busca2['QTDE_LOTE'] - $qLote;
        $update_lote    = mysqli_query($conectDB, "UPDATE reagentes_lotes SET QTDE_LOTE = '$retira_lote', OBSERVACAO = '$obsv',
                                                    RESPONSAVEL = '$respons' WHERE NUMERO_LOTE = '$nLote'");
        // volta ao início da rotina
        header('Location: P81RetiradaEstoque.php');
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
    <form action="" method="POST">
    <p style="text-align: center; color: red;"><?php echo '<br>'; echo $_SESSION['alerta'] ?></p>
    <div class="mainBox">
        <fieldset>
            <legend>Dados do Reagente</legend>
            <br>
            <div class="box1esq">
                <div class="inputBox">
                    <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['codReag'] ?>">
                    <label class="labelInput" for="">Codigo do Reagente</label>
                </div>
            </div>
            <div class="box1dir">
                <div class="inputBox">
                    <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['mkrReag'] ?>">
                    <label class="labelInput" for="">Marca/Fornecedor</label>
                </div>
            </div>               
            <div class="box2esq">
                <div class="inputBox">
                    <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['dscReag'] ?>">
                    <label class="labelInput" for="">Descrição do Produto</label>
                </div>
            </div>                 
            <div class="box3esq">
                <div class="inputBox">
                <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['embReag'] ?>">
                    <label class="labelInput" for="">Embalagem</label>
                </div>
            </div> 
            <div class="box3mid">
                <div class="inputBox">
                <input class="inputUser" type="number" id="" name="" value="<?php echo $_SESSION['ctdReag'] ?>">
                    <label class="labelInput" for="">Conteúdo Líquido</label>
                </div>
            </div> 
            <div class="box3dir">
                <div class="inputBox">
                <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['uniReag'] ?>">
                    <label class="labelInput" for="">Unidade</label>
                </div>
            </div> 
            <div class="box4esq">
            <div class="inputBox">
                <input class="inputUser" type="number" id="" name="" value="<?php echo $_SESSION['cotaSgr'] ?>">
                    <label class="labelInput" for="">Cota de Segurança</label>
                </div>
            </div> 
            <div class="box4dir">
                <div class="inputBox">
                <input class="inputUser" type="text" id="" name="" value="<?php echo $_SESSION['qEstoque'] ?>">
                    <label class="labelInput" for="">Atual Quantidade em Estoque</label>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>Dados do Lote</legend>
            <datalist id="lotes">           
                <?PHP
                    $codigo = $_SESSION['codReag'];
                    $sql_lotes = "SELECT * FROM reagentes_lotes WHERE CODIGO_REAGENTE = '$codigo'";
                    $busca_lote = $conectDB->query($sql_lotes) or die('Falha na execução do código SQL  "<a href="index.php">Entrar</a>"');
                    $acha_lote = $busca_lote->fetch_assoc();
                    $contagem = mysqli_num_rows($busca_lote);
                    $sql2 = mysqli_query($conectDB, $sql_lotes);
                    while($aux = mysqli_fetch_assoc($sql2)){ ?>
                        <option value="<?php echo $aux['NUMERO_LOTE'] ?>"><?php
                    }
                ?>
            </datalist>
            <br>
            <div class="box5esq">
                <div class="inputBox">
                <input class="inputUser" list="lotes" id="nLote" name="nLote" style="text-transform: uppercase" required>
                    <label class="labelInput" for="nLote">No. do Lote(selecione)</label>
                </div>
            </div> 
            <div class="box5dir">
                
            </div>
            <div class="box6esq">
            <br>
                <div class="inputBox">
                    <input class="inputUser" type="number" id="qLote" name="qLote" required>
                    <label class="labelInput" for="qLote">Quantidade Retirada</label>
                </div>
            </div> 
            <div class="box6dir">
            </div> 
            <div class="box7esq">
            </div>
            <div class="box7dir">
            <textarea name="observacao" id="observacao" cols="40" rows="5">Observações:</textarea>
            </div>
            <div class="box8esq">
                <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">
                <input class="b2" type="reset" value="Sair"   id="botao" onclick="location.href='P03LogOut.php'">
            </div>
            <div class="box8dir">
            
            <input type="submit" id="submit" name="submit" value="Confirmar">
            </div>
        </fieldset>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
    </form>
</body>
</html>