<?php
    include_once('P01.ConectDB.php');

        //verifica se sessão está ativa e reativa
        if(!isset($_SESSION)){
            session_start();
        }
        $dia = strtotime($_SESSION['dataLogin']);
        echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);
        $logado = $_SESSION['usuario'];

        if(isset($_POST['submit']) && !empty($_POST['nomeF']) && !empty($_POST['deptoF']) && !empty($_POST['cargoF'])){
            // Acessa
            $nome = $conectDB->real_escape_string($_POST['nomeF']);
            $dept = $conectDB->real_escape_string($_POST['deptoF']);          
            $carg = $conectDB->real_escape_string($_POST['cargoF']);
            echo $novo;
            
    
            $sql_busca = "SELECT * FROM funcionario WHERE NOME_FUNCIONARIO = '$nome' AND DEPARTAMENTO = '$dept' AND CARGO = '$carg'";
    
            $busca     = $conectDB->query($sql_busca) or die("Falha na execução do código SQL");
            $resultado = $busca->fetch_assoc();
            $contador  = mysqli_num_rows($busca);
            
            if($contador == 1){
                
            }
        }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funcionário | Reboot ID</title>
</head>
<body>
    <input type="text" id="" name="" placeholder="Nome Completo">
</body>
</html>