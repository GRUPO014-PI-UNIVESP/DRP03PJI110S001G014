<?php
    include('P01.ConectDB.php');

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

    if(isset($_POST['codAmostra'])){

        $codAmostra = strtoupper($conectDB->real_escape_string($_POST['codAmostra']));

        $sql_busca = "SELECT * FROM amostras WHERE CODIGO_AMOSTRA = '$codAmostra' ";
        $sql_result = $conectDB->query($sql_busca) or die();
        $resultado  = $sql_result->fetch_assoc();
        $contador   = mysqli_num_rows($sql_result);

        if($contador > 0){
            header('Location: P63.Mensagem.php');
        }

    }
    if(isset($_POST['submit'])){
        $tipAmostra = strtoupper($_POST['tipAmostra']);
        $dscAmostra = strtoupper($_POST['dscAmostra']);
        $cliente    = strtoupper($_POST['cliente']);
        $contato    = strtoupper($_POST['contato']);
        $telefone   = $_POST['telefone'];

        $registro = mysqli_query($conectDB, "INSERT INTO amostras(CODIGO_AMOSTRA, DESCRICAO_AMOSTRA, TIPO_AMOSTRA, CLIENTE_FORNECEDOR, NOME_CONTATO,
                                    TELEFONE_CONTATO) VALUES('$codAmostra', '$dscAmostra', '$tipAmostra', '$cliente', '$contato', '$telefone')");
        
        header('Location: P61.CadastroAmostra.php');
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
        <form action="" method="POST">
            <br>
            <fieldset>
                <legend>Cadastro de Novas Amostras de Análise</legend>
                <div class="linha1esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="codAmostra" name="codAmostra" 
                                style="text-align:center; text-transform: uppercase" value="<?php echo $codAmostra ?>">
                        <label class="labelInput" for="codAmostra">Código da Amostra</label>
                    </div>
                </div>
                <div class="linha1dir">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="tipAmostra" name="tipAmostra" style="text-transform: uppercase" onfocus required>
                        <label class="labelInput" for="tipAmostra">Tipo da Amostra</label>
                    </div>
                </div>
                <div class="linha2esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="dscAmostra" name="dscAmostra" style="text-transform: uppercase" required>
                        <label class="labelInput" for="dscAmostra">Descrição da Amostra</label>
                    </div>
                </div>
                <div class="linha3esq">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="cliente" name="cliente" style="text-transform: uppercase" required>
                        <label class="labelInput" for="cliente">Cliente/Fornecedor</label>
                    </div>
                </div>
                <div class="linha3mid">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="contato" name="contato" style="text-transform: uppercase">
                        <label class="labelInput" for="contato">Nome do Contato</label>
                    </div>
                </div>
                <div class="linha3dir">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser"  type="text" id="telefone" name="telefone" style="text-transform: uppercase">
                        <label class="labelInput" for="telefone">Telefone</label>
                    </div>
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
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20.MenuGQ.php'">
                    <input class="b2" type="reset" value="Sair" id="botao" onclick="location.href='P03.LogOut.php'">
                    <input type="submit" id="submit" name="submit" value="Confirmar">
                    <br>
                </div>
                <br>
            </fieldset>
        </form>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div> 
</body>
</html>