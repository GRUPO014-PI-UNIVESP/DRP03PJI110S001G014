<?php
    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    include('P01ConectDB.php');
    
    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}
    
    $dia = strtotime($_SESSION['dataLogin']);
    echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
        die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');    
    }
    if(isset($_POST['nome']) && !empty($_POST['nascimento'])){

        $_SESSION['nomeFunc'] = $conectDB->real_escape_string(strtoupper($_POST['nome']));
        $_SESSION['nascFunc'] = $_POST['nascimento'];
        $nomeFunc = $conectDB->real_escape_string(strtoupper($_POST['nome']));
        $nascFunc = $_POST['nascimento'];
        $nasc     = $nascFunc;

        $sql_busca = "SELECT * FROM funcionario WHERE NOME_FUNCIONARIO = '$nomeFunc' AND DATA_NASCIMENTO = '$nascFunc'";
        $sql_result = $conectDB->query($sql_busca) or die("Falha na execução do código SQL");
        $buscaResult = $sql_result->fetch_assoc();
        $contador = mysqli_num_rows($sql_result);
        if($contador != 0){
            header('Location: P12Mensagem.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Funcionários</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.4.1/jquery.maskedinput.min.js"></script>
</head>
<style>
body{background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke; font-size: 12px;}
fieldset{border-radius: 8px;border-color: whitesmoke;}
.mainBox{position: absolute; padding: 10px; border-radius: 10px; background-color: rgb(0, 0, 0, 0.5); width: 92%; height: 75%; top: 50%; left: 50%; transform: translate(-50%, -50%);}
.box1esq{width: 32%; height: 35px;  padding: 5px; float: left;}
.box1dir{width: 65%; height: 35px;  padding: 5px; float: left;}
.box2esq{width: 32%; height: 35px;  padding: 5px; float: left;}
.box2dir{width: 65%; height: 35px;  padding: 5px; float: left;}
.box3esq{width: 10%; height: 35px;  padding: 5px; float: left;}
.box3miL{width: 10%; height: 35px;  padding: 5px; float: left;}
.box3miR{width: 38%; height: 35px;  padding: 5px; float: left;}
.box3dir{width: 37%; height: 35px;  padding: 5px; float: left;}
.box4esq{width: 60%; height: 35px;  padding: 5px; float: left;}
.box4dir{width: 37%; height: 35px;  padding: 5px; float: left;}
.box5esq{width: 150px; height: 200px; padding: 5px; float: left;}
.box5spc{width: 010px; height: 200px; padding: 5px; float: left;}
.box5mid{width: 250px; height: 200px; padding: 5px; float: left;}
.box5dir{width: 250px; height: 200px; padding: 5px; float: left;}
.box5View{background-color: rgba(0, 0, 0, 0.2); width: 280px; height: 200px; padding: 5px; float: left;}
.box6esq{width: 850px; height: 80px; padding: 5px; float: left;}
.boxBotoes{width: 380px; height: 40px; padding: 5px; float: left;}
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
            <form action="P13FormularioView.php" method="POST">
                <legend>Cadastro de Novo Funcionário</legend>
                    <div class="box1esq">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="nascimento" id="nascimento" value="<?php echo date('d/m/Y', strtotime($_SESSION['nascFunc'])) ?>">
                            <label class="labelInput" for="nascimento" >Data de Nascimento</label>
                        </div>
                    </div>
                    <div class="box1dir">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="nome" id="nome" style="text-transform: uppercase" value="<?php echo strtoupper($_SESSION['nomeFunc']) ?>">
                            <label class="labelInput" for="nome" >Nome Completo*</label>
                        </div>
                    </div>
                    <div class="box2esq">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="tel" name="telefone" id="telefone" maxlength="11" autofocus required>
                            <label class="labelInput" for="telefone" >Telefone*  somente números (11)</label>
                        </div>
                    </div>
                    <div class="box2dir">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="email" id="email" style="text-transform: lowercase" required>
                            <label class="labelInput" for="email" >E-mail*</label>
                        </div>
                    </div>
                    <div class="box3esq">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="cep" id="cep" maxlength="8" >
                            <label class="labelInput" for="cep" >CEP</label>
                        </div>
                    </div>
                    <div class="box3miL">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="estado" id="estado" style="text-transform: uppercase" maxlength="2">
                            <label class="labelInput" for="estado" >UF:</label>
                        </div>
                    </div>
                    <div class="box3miR">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="cidade" id="cidade" style="text-transform: uppercase" >
                            <label class="labelInput" for="cidade" >Cidade</label>
                        </div>
                    </div>
                    <div class="box3dir">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="bairro" id="bairro" style="text-transform: uppercase" >
                            <label class="labelInput" for="bairro" >Bairro</label>
                        </div>
                    </div>
                    <div class="box4esq">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="logradouro" id="logradouro" style="text-transform: uppercase" >
                            <label class="labelInput" for="logradouro" >Logradouro</label>
                        </div>
                    </div>
                    <div class="box4dir">
                        <br>
                        <div class="inputBox">
                            <input class="inputUser" type="text" name="nResidencia" id="nResidencia" >
                            <label class="labelInput" for="nResidencia" >Número / Bloco / Apto</label>
                        </div>
                    </div>
                    <div class="box5esq">
                        <br>
                        <label for="admissao">Data de Admissão*:</label><br><br>
                        <input type="date" name="admissao" id="datas" required>
                    </div>
                    <div class="box5spc">
                    </div>
                    <div class="box5mid">
                        <br>
                        <fieldset>
                            <legend>Departamento*</legend>
                            <input type="radio" id="admin" name="departamento" value="ADMINISTRAÇÃO" required>
                            <label for="admin">Administração</label>
                            <br>
                            <input type="radio" id="Gquali" name="departamento" value="GARANTIA DE QUALIDADE" required>
                            <label for="Gquali">Garantia de Qualidade</label>
                            <br>
                            <input type="radio" id="producao" name="departamento" value="PRODUÇÃO" required>
                            <label for="producao">Produção</label>
                            <br>
                            <input type="radio" id="logistica" name="departamento" value="LOGÍSTICA" required>
                            <label for="logistica">Logística</label>
                            <br>
                        </fieldset>
                    </div>
                    <div class="box5dir">
                        <br>
                        <fieldset>
                            <legend>Cargo/Função*</legend>
                            <input type="radio" id="diretor" name="cargo" value="DIRETOR(A)" required>
                            <label for="diretor">Diretor(a)</label>
                            <br>
                            <input type="radio" id="super" name="cargo" value="SUPERVISOR(A)" required>
                            <label for="super">Supervisor(a)</label>
                            <br>
                            <input type="radio" id="engenheiro" name="cargo" value="ENGENHEIRO(A)" required>
                            <label for="engenheiro">Engenheiro(a)</label>
                            <br>
                            <input type="radio" id="analista" name="cargo" value="ANALISTA" required>
                            <label for="analista">Analista</label>
                            <br>
                            <input type="radio" id="assistente" name="cargo" value="ASSISTENTE" required>
                            <label for="assistente">Assistente</label>
                            <br>
                            <input type="radio" id="operador" name="cargo" value="OPERADOR(A)" required>
                            <label for="operador">Operador(a)</label>
                            <br>
                        </fieldset>
                    </div>
                    <br>
                    <div class="box5View">
                        <br>
                    </div>
                    <div class="box6esq">
                    </div>
                    <div class="boxBotoes">
                        <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P11MenuAdmin.php'">
                        <input class="b2" type="reset" value="Sair"   id="botao" onclick="location.href='P03LogOut.php'"> 
                    </div>
                    <div class="boxSub">
                        <input type="submit" id="submit" name="submit" value="Confirmar" onfocus required>
                    </div> 
            </form>
        </fieldset>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>
