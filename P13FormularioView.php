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
     // após submit verifica se campos estavam preenchidos
    if(isset($_POST['submit']) && !empty($_POST['nome']) && !empty($_POST['nascimento'])){
    // prepara variáveis para inserir dados no banco de dados, e prevenção de SQL injection
    $nomeFunc = $_SESSION['nomeFunc'];
    $nascFunc = $_SESSION['nascFunc'];
    $nasc     = $nascFunc;
    $tele = $conectDB->real_escape_string(           $_POST['telefone']);
    $emai = $conectDB->real_escape_string(strtolower($_POST['email']));
    $admi = $conectDB->real_escape_string(          ($_POST['admissao']));
    $dept = $conectDB->real_escape_string(           $_POST['departamento']);
    $carg = $conectDB->real_escape_string(           $_POST['cargo']);
    $nCep = $conectDB->real_escape_string(           $_POST['cep']);
    $sUFs = $conectDB->real_escape_string(strtoupper($_POST['estado']));
    $city = $conectDB->real_escape_string(strtoupper($_POST['cidade']));
    $bair = $conectDB->real_escape_string(strtoupper($_POST['bairro']));
    $logr = $conectDB->real_escape_string(strtoupper($_POST['logradouro']));
    $nRes = $conectDB->real_escape_string(           $_POST['nResidencia']);
    // criando ID de usuários e senha provisórios
    $idP1   = substr($nomeFunc, 0, 5);
    $idP2   = substr($nascFunc, -2);
    $idProv = $idP1 . $idP2;
    $pwProv = substr($tele, -6);
    // máscara do telefone para (xx)x xxxx-xxxx
    $tlP1   = substr($tele, 0, 2);
    $tlP2   = substr($tele, -9, -4);
    $tlP3   = substr($tele, -4);
    $telBR  = '(' . $tlP1 . ')' . $tlP2 . '-' . $tlP3;
    // atribui credencial de acordo com o cargo ou função
    switch($carg){
        case 'DIRETOR(A)':    $cred = 3; break;
        case 'SUPERVISOR(A)': $cred = 3; break;
        case 'ENGENHEIRO(A)': $cred = 2; break;
        case 'ANALISTA':      $cred = 2; break;
        case 'ASSISTENTE':    $cred = 1; break;
        case 'OPERADOR(A)':   $cred = 1; break;
    }

        // comando de inserção dos dados do funcionário
        $cadastra = mysqli_query($conectDB, "INSERT INTO funcionario(NOME_FUNCIONARIO, DATA_NASCIMENTO, TELEFONE_FUNCIONARIO,
                        EMAIL_FUNCIONARIO, DATA_ADMISSAO, DEPARTAMENTO, CARGO, CREDENCIAL, ID_USUARIO, SENHA_USUARIO,
                        DOMICILIO_CEP, DOMICILIO_RUA, DOMICILIO_NUMERO, DOMICILIO_BAIRRO, DOMICILIO_CIDADE, DOMICILIO_UF)
                    VALUES ('$nomeFunc', '$nasc', '$telBR', '$emai', '$admi', '$dept', '$carg', '$cred', '$idProv', '$pwProv',
                        '$nCep', '$logr', '$nRes', '$bair', '$city', '$sUFs')");
        //criação de variáveis de sessão para próxima página de verificação de dados
        $_SESSION['teleFunc'] = $telBR;
        $_SESSION['emaiFunc'] = $emai;
        $_SESSION['admiFunc'] = $admi;
        $_SESSION['deptFunc'] = $dept;
        $_SESSION['cargFunc'] = $carg;
        $_SESSION['credFunc'] = $cred;
        $_SESSION['idUsFunc'] = $idProv;
        $_SESSION['pwUsFunc'] = $pwProv;
        $_SESSION['nCepFunc'] = $nCep;
        $_SESSION['estaFunc'] = $sUFs;
        $_SESSION['cityFunc'] = $city;
        $_SESSION['bairFunc'] = $bair;
        $_SESSION['logrFunc'] = $logr;
        $_SESSION['nResFunc'] = $nRes;
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionários | Cadastro</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
</head>
<style>
body{background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; color: whitesmoke; font-size: 13px;}
fieldset{border-radius: 8px; border-color: whitesmoke;}
legend{text-align: center; font-size: 18px;}
.mainBox{position: absolute; color: white; background-color: rgba(0, 0, 0, 0.5); padding: 10px; border-radius: 10px; width: 900px; height: 600px; top: 50%; left: 50%; transform: translate(-50%,-50%);}
.box1esq{background-color: none; width: 300px; height: 35px;  padding: 5px; float: left;}
.box1dir{background-color: none; width: 550px; height: 35px;  padding: 5px; float: left;}
.box2esq{background-color: none; width: 350px; height: 35px;  padding: 5px; float: left;}
.box2dir{background-color: none; width: 500px; height: 35px;  padding: 5px; float: left;}
.box3esq{background-color: none; width: 150px; height: 35px;  padding: 5px; float: left;}
.box3miL{background-color: none; width: 75px;  height: 35px;  padding: 5px; float: left;}
.box3miR{background-color: none; width: 345px; height: 35px;  padding: 5px; float: left;}
.box3dir{background-color: none; width: 255px; height: 35px;  padding: 5px; float: left;}
.box4esq{background-color: none; width: 500px; height: 35px;  padding: 5px; float: left;}
.box4dir{background-color: none; width: 348px; height: 35px;  padding: 5px; float: left;}
.box5esq{background-color: none; width: 150px; height: 200px; text-align: center; padding: 5px; float: left;}
.box5spc{background-color: none; width: 10px;  height: 200px; padding: 5px; float: left;}
.box5mid{background-color: none; width: 180px; height: 200px; padding: 5px; float: left;}
.box5dir{background-color: none; width: 180px; height: 200px; padding: 5px; float: left;}
.box5View{background-color: rgba(0, 0, 0, 0.2); width: 280px; height: 200px; padding: 5px; float: left; text-align: center;}
.box6esq{background-color: none; width: 850px; height: 80px; padding: 5px; float: left;}
.boxBotoes{background: none; width: 380px; height: 40px; padding: 5px; float: left;}
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
<script>
	$("#telefone").mask("(99) 99999-9999");
	$("#cep").mask("99999-999");
	$("#cpf").mask("999.999.999-99");
	$("#cnpj").mask("99.999.999/9999-99");
</script>
        <div class="mainBox">
            <fieldset>
                <legend>Quadro de Funcionários - Cadastro</legend>
                <br>
                <div class="box1esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nome" value="<?php echo $_SESSION['nomeFunc'] ?>">
                        <label class="labelInput" for="nome" >Nome Completo</label>
                    </div>
                </div>
                <div class="box1dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nascimento" value="<?php echo date('d/m/Y', strtotime($_SESSION['nascFunc'])) ?>">
                        <label class="labelInput" for="nascimento">Data de Nascimento:</label>
                    </div>
                </div>
                <div class="box2esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="telefone" value="<?php echo $_SESSION['teleFunc'] ?>">
                        <label class="labelInput" for="telefone" >Telefone(somente números)</label>
                    </div>
                </div>
                <div class="box2dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="email" value="<?php echo $_SESSION['emaiFunc'] ?>">
                        <label class="labelInput" for="email" >E-mail</label>
                    </div>
                </div>
                <div class="box3esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="cep" value="<?php echo $_SESSION['nCepFunc'] ?>">
                        <label class="labelInput" for="cep" >CEP</label>
                    </div>
                </div>
                <div class="box3miL">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="estado" value="<?php echo $_SESSION['estaFunc'] ?>">
                        <label class="labelInput" for="estado" >UF:</label>
                    </div>
                </div>
                <div class="box3miR">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="cidade" value="<?php echo $_SESSION['cityFunc'] ?>">
                        <label class="labelInput" for="cidade" >Cidade</label>
                    </div>
                </div>
                <div class="box3dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="bairro" value="<?php echo $_SESSION['bairFunc'] ?>">
                        <label class="labelInput" for="bairro" >Bairro</label>
                    </div>
                </div>
                <div class="box4esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="logradouro" value="<?php echo $_SESSION['logrFunc'] ?>">
                        <label class="labelInput" for="logradouro" >Logradouro</label>
                    </div>
                </div>
                <div class="box4dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="numero" value="<?php echo $_SESSION['nResFunc'] ?>">
                        <label class="labelInput" for="numero" >Número / Bloco / Apto</label>
                    </div>
                </div>
                <div class="box5esq">
                    <br>
                    <label for="admissao">Data de Admissão:</label><br><br>
                    <input class="inputUser" type="text" value="<?php echo date('d/m/Y', strtotime($_SESSION['admiFunc'])) ?>">
                </div>
                <div class="box5spc">
                </div>
                <div class="box5mid">
                    <p>Departamento</p>
                    <input class="inputUser" type="text" value="<?php echo $_SESSION['deptFunc'] ?>">
                </div>
                <div class="box5dir">
                    <p>Cargo</p>
                    <input class="inputUser" type="text" value="<?php echo $_SESSION['cargFunc'] ?>">
                </div>
                <div class="box5View">
                    <p style="font-size: 13px;">ID Usuário Provisório</p>
                    <p style="font-size: 22px; color: yellow"><?php echo $_SESSION['idUsFunc'] ?></p>
                    <br>
                    <p style="font-size: 13px;">Senha Provisória</p>
                    <p style="font-size: 22px; color: yellow"><?php echo $_SESSION['pwUsFunc'] ?></p>
                </div>
                <div class="box6esq">
                </div>
                <div class="boxBotoes">
                </div>
                <div class="boxSub">
                    <input type="reset" id="submit" name="submit" value="Encerrar" onfocus onclick="location.href='P12PrimeiroFormulario.php'">
                </div>              
            </fieldset>
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
        </div>
</body>
</html>