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
    if(isset($_POST['codReag'])){

        $codReag      = $conectDB->real_escape_string(strtoupper($_POST['codReag']));
        $sql_acha     = "SELECT * FROM reagentes_estoque WHERE CODIGO_REAGENTE = '$codReag'";
        $resultado    = $conectDB->query($sql_acha) or die('Falha na execução do código SQL  "<a href="index.php">Entrar</a>"');
        $buscador     = $resultado->fetch_assoc();

        if(mysqli_num_rows($resultado) < 1){
            $_SESSION['alerta']  = 'Produto não cadastrado, favor verificar e retomar a ação novamente  "<a href="P20.MenuGQ.php">Entrar</a>"';
            echo $_SESSION['alerta'];     
        } else{
            $_SESSION['alerta']  = '';
            $_SESSION['codReag'] = strtoupper($codReag);
            $_SESSION['mkrReag'] = strtoupper($buscador['MARCA_REAGENTE']);
            $_SESSION['dscReag'] = strtoupper($buscador['DESCR_REAGENTE']);
            $_SESSION['embReag'] = strtoupper($buscador['EMBALAGEM']);
            $_SESSION['ctdReag'] =            $buscador['CONTEUDO_REAGENTE'];
            $_SESSION['uniReag'] = strtolower($buscador['UNIDADE']);
            $_SESSION['cotaSgr'] =            $buscador['COTA_LIMITE'];
            $_SESSION['fispq']   =            $buscador['FISPQ'];
            $_SESSION['qEstoque']=            $buscador['QTDE_ESTOQUE'];
                
            header('Location: P42ReposicaoEStoque.php');
        }
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
    .box1mid{background-color: none;width: 60px;height: 35px;padding: 5px;float: left;}
    .box1dir{background-color: none;width: 355px;height: 35px;padding: 5px;float: left;}
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
    .b2{background-color: dodgerblue;color:whitesmoke;width: 30%;height: 33px;font-size: 13px;cursor: pointer;outline: none;padding: 4px;float: left;}
    #botao:hover{background-color: crimson;}
    #datas{background-color: rgba(0, 0, 0, 0.2);color: whitesmoke;border: none;padding: 8px;border-radius: 10px;outline: none;font-size: 15px;}
    #submit{background-color: dodgerblue;width: 100%;border: none;padding: 10px;color: white;font-size: 14px;cursor: pointer;border-radius: 10px;float: right;}
    #submit:hover{background-color: darkblue;}
</style>
<body>
    <form action="" method="POST">
    <div class="mainBox">
        <fieldset>
            <legend>Reposição de Estoque - Dados do Reagente</legend>
            <br>
            <div class="box1esq">
                <div class="inputBox">
                    <input class="inputUser" type="text" id="codReag" name="codReag" style="text-transform: uppercase" onchange="this.form.submit()" required>
                    <label class="labelInput" for="codReag">Codigo do Reagente</label>
                </div>
            </div>
        </fieldset>
                <br><br><br>
                <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">
                <input class="b2" type="reset" value="Sair"   id="botao" onclick="location.href='P03LogOut.php'">
            </div>
    </div>
    </form>
</body>
</html>