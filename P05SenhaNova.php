<?php
    include_once('P01ConectDB.php');

        //verifica se sessão está ativa e reativa
        if(!isset($_SESSION)){
            session_start();
        }
        $dia = strtotime($_SESSION['dataLogin']);
        echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);
        $logado = $_SESSION['usuario'];

        if(isset($_POST['submit']) && !empty($_POST['usuario']) && !empty($_POST['senha'])){
            // Acessa
            $user = $conectDB->real_escape_string($_POST['usuario']);
            $pass = $conectDB->real_escape_string($_POST['senha']);          
            $novo = $conectDB->real_escape_string($_POST['newSenha']);
            
            // variável do comando sql
            $sql_code = "SELECT * FROM funcionario WHERE ID_USUARIO = '$user' and SENHA_USUARIO = '$pass'";
    
            $busca    = $conectDB->query($sql_code) or die("Falha na execução do código SQL");
            $nome     = $busca->fetch_assoc();
            $contador = mysqli_num_rows($busca);
            // verifica se funcionario existe
            if($contador < 1){
                unset($_SESSION['usuario']);
                unset($_SESSION['senha']);
                header('Location: index.php');
            }else{
                // verifica se entrada de senha coincide
                if(($_POST['newSenha'] == $_POST['repSenha'])){

                    $senha  = $conectDB->real_escape_string($_POST['newSenha']);
                    $idUser = $conectDB->real_escape_string($_POST['idUser']);
                    // faz a atualização da nova senha
                    $result = mysqli_query($conectDB, "UPDATE funcionario SET ID_USUARIO = '$idUser', SENHA_USUARIO = '$senha' 
                                    WHERE ID_USUARIO = '$logado'");
                    header("Location: P03LogOut.php");
                }else{
                    header("Location: P06SenhaErro.php");
                }

            }
        }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Troca de Senha</title>
</head>
<style>
body    {background-color: mediumseagreen;font-family: Arial, Helvetica, sans-serif;color: whitesmoke;}
fieldset{padding: 10px;color: whitesmoke;border-radius: 6px;}
#mainBox{background-color: rgba(100, 100, 100, 0.7);position: absolute;padding: 15px;border-radius: 10px;width: 300px;height: 350px;top: 50%;left: 50%;transform: translate(-50%,-50%); }
.user   {background-color: rgba(50, 50, 50, 0.7);border: none;padding: 4px;border-radius: 5px;width: 142px;text-align: center;color: whitesmoke;}
.pass   {background-color: dodgerblue;border: none;padding: 4px;border-radius: 5px;width: 80px;text-align: center;color: whitesmoke;}
#submit {background-color: dodgerblue;width: 100%;border: none;padding: 6px;color: white;font-size: 14px;cursor: pointer;border-radius: 8px;}
#submit:hover{background-color: darkblue;}
</style>
<body>
    <form action ="" method ="POST">
        <br><br><br>
        <div id="mainBox">
            <p>"NovoUser" deve modificar para um novo ID de Usuário</p>
            <fieldset>
                <legend>Troca de Senha</legend>
                <label for="idUser">ID do Usuário:</label>
                <input class="user" type="text" id="idUser" name="idUser" value="<?php echo $logado?>" required>
                <br><br>
                <label for="newSenha">Nova Senha(6 dígitos):</label>
                <input class="pass" type="password" id="newSenha" name="newSenha" required>
                <br><br>
                <label for="repSenha">Repita Senha..............:</label>
                <input class="pass" type="password" id="repSenha" name="repSenha" required>
                <br><br>
                <input type="submit" name="submit" id="submit">
            </fieldset><br>
            <input type="reset" value="Voltar" onclick="location.href='P03.LogOut.php'">
        </div>
    </form>
</body>
</html>