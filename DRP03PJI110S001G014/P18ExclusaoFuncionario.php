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
     if(!empty($_GET['id'])){

        $id = $_GET['id'];

        $sql_buscaID = "SELECT * FROM funcionario WHERE ID_FUNCIONARIO = '$id'";
        $resposta    = $conectDB->query($sql_buscaID) or die();
        $verificador = mysqli_num_rows($resposta);
        if($verificador == 0){
            header('Location: P14AtualizaFuncionario.php');
        }
        while($editar = mysqli_fetch_assoc($resposta)){
            $_SESSION['nuIDFunc'] = $editar['ID_FUNCIONARIO'];
            $_SESSION['nomeFunc'] = $editar['NOME_FUNCIONARIO'];
            $_SESSION['nascFunc'] = $editar['DATA_NASCIMENTO'];           
            $_SESSION['teleFunc'] = $editar['TELEFONE_FUNCIONARIO'];
            $_SESSION['emaiFunc'] = $editar['EMAIL_FUNCIONARIO'];
            $_SESSION['admiFunc'] = $editar['DATA_ADMISSAO'];
            $_SESSION['deptFunc'] = $editar['DEPARTAMENTO'];
            $_SESSION['cargFunc'] = $editar['CARGO'];
            $_SESSION['credFunc'] = $editar['CREDENCIAL'];
            $_SESSION['idUsFunc'] = $editar['ID_USUARIO'];
            $_SESSION['pwUsFunc'] = $editar['SENHA_USUARIO'];
            $_SESSION['nCepFunc'] = $editar['DOMICILIO_CEP'];
            $_SESSION['estaFunc'] = $editar['DOMICILIO_UF'];
            $_SESSION['cityFunc'] = $editar['DOMICILIO_CIDADE'];
            $_SESSION['bairFunc'] = $editar['DOMICILIO_BAIRRO'];
            $_SESSION['logrFunc'] = $editar['DOMICILIO_RUA'];
            $_SESSION['nResFunc'] = $editar['DOMICILIO_NUMERO']; 
        }
     }
     if(isset($_POST['submit'])){
    
        $confirma = $_SESSION['nuIDFunc'];
        $deleta = mysqli_query($conectDB, "DELETE FROM funcionario WHERE ID_FUNCIONARIO = '$confirma'");

        header('Location: P14AtualizaFuncionario.php');
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
.box5esq{background-color: none; width: 150px; height: 60px; text-align: center; padding: 5px; float: left;}
.box5spc{background-color: none; width: 10px;  height: 60px; padding: 5px; float: left;}
.box5mid{background-color: none; width: 180px; height: 60px; padding: 5px; float: left;}
.box5dir{background-color: none; width: 180px; height: 60px; padding: 5px; float: left;}
.box5fim{background-color: none; width: 180px; height: 60px; padding: 5px; float: left;}
.box6esq{background-color: none; width: 170px; height: 200px; padding: 5px; float: left;}
.box6mid{background-color: none; width: 180px; height: 200px; padding: 5px; float: left;}
.box6dir{background-color: none; width: 180px; height: 200px; padding: 5px; float: left;}
.boxBotoes{background-color: none; width: 380px; height: 40px; padding: 5px; float: left;}
.boxSub{background-color: none; width: 200px; height: 40px; padding: 5px; float: right;}
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
            <form action="" method="POST">
            <fieldset>
                <legend>Quadro de Funcionários - Excluir</legend>
                <br>
                <div class="box1esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nome" name="nome" value="<?php echo $_SESSION['nomeFunc'] ?>">
                        <label class="labelInput" for="nome" >Nome Completo</label>
                    </div>
                </div>
                <div class="box1dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nascimento" name="nascimento" value="<?php echo date('d/m/Y', strtotime($_SESSION['nascFunc'])) ?>">
                        <label class="labelInput" for="nascimento">Data de Nascimento:</label>
                    </div>
                </div>
                <div class="box2esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="telefone" name="telefone" maxlength="11" value="<?php echo $_SESSION['teleFunc'] ?>">
                        <label class="labelInput" for="telefone" >Telefone(somente números)</label>
                    </div>
                </div>
                <div class="box2dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="email" name="email" style="text-transform: lowercase" value="<?php echo $_SESSION['emaiFunc'] ?>">
                        <label class="labelInput" for="email" >E-mail</label>
                    </div>
                </div>
                <div class="box3esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="cep" name="cep" maxlength="8" value="<?php echo $_SESSION['nCepFunc'] ?>">
                        <label class="labelInput" for="cep" >CEP</label>
                    </div>
                </div>
                <div class="box3miL">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="estado" name="estado" style="text-transform: uppercase" value="<?php echo $_SESSION['estaFunc'] ?>">
                        <label class="labelInput" for="estado" >UF:</label>
                    </div>
                </div>
                <div class="box3miR">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="cidade" name="cidade" style="text-transform: uppercase" value="<?php echo $_SESSION['cityFunc'] ?>">
                        <label class="labelInput" for="cidade" >Cidade</label>
                    </div>
                </div>
                <div class="box3dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="bairro" name="bairro" style="text-transform: uppercase" value="<?php echo $_SESSION['bairFunc'] ?>">
                        <label class="labelInput" for="bairro" >Bairro</label>
                    </div>
                </div>
                <div class="box4esq">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="rua" name="rua" style="text-transform: uppercase" value="<?php echo $_SESSION['logrFunc'] ?>">
                        <label class="labelInput" for="rua" >Logradouro</label>
                    </div>
                </div>
                <div class="box4dir">
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nResid" name="nResid" value="<?php echo $_SESSION['nResFunc'] ?>">
                        <label class="labelInput" for="nResic" >Número / Bloco / Apto</label>
                    </div>
                </div>
                <div class="box5esq">
                    <br>
                    <label for="admissao">Data de Admissão:</label><br><br>
                    <input class="inputUser" type="text" name="admissao" value="<?php echo date('d/m/Y', strtotime($_SESSION['admiFunc'])) ?>">
                </div>
                <div class="box5spc">
                </div>
                <div class="box5mid">
                    <p>Departamento</p>
                    <input class="inputUser" type="text" name="departamento" value="<?php echo $_SESSION['deptFunc'] ?>">
                </div>
                <div class="box5dir">
                    <p>Cargo</p>
                    <input class="inputUser" type="text" name="cargo" value="<?php echo $_SESSION['cargFunc'] ?>">
                </div>
                <div class="box5fim">
                </div>
                <div class="box6esq">
                </div>
                <div class="box6mid">

                </div>
                <div class="box6dir">

                </div>
                <div class="boxBotoes">
                    <input type="button" id="" name="voltar" value="Voltar" onclick="location.href='P14AtualizaFuncionario.php'">
                    <input type="button" id="" name="sair"   value="Sair"   onclick="location.href='P11MenuAdmin.php'">
                </div>
                <div class="boxSub">
                    <form action="" method="POST">
                        <input type="submit" id="submit" name="submit" value="Confirmar Exclusão">
                    </form>
                </div>              
            </fieldset>
            </form>
            <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
        </div>
</body>
</html>