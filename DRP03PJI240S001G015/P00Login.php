<?php

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    // chama rotina de conexão com banco de dados
    include('P01ConectDB.php');
    
    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}

      // verifica se botão enviar foi acionado e campos foram preenchidos
      if(isset($_POST['submit']) && !empty($_POST['usuario']) && !empty($_POST['senha'])){
        
        $user = $conectDB->real_escape_string($_POST['usuario']);
        $pass = $conectDB->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM quadro_funcionarios WHERE ID_USUARIO = '$user' and SENHA_USUARIO = '$pass'";

        $result   = $conectDB->query($sql_code) or die("Falha na execução do código SQL");
        $nome     = $result->fetch_assoc();

        // verifica se existe usuário
        if(mysqli_num_rows($result) < 1){
            unset($_SESSION['usuario']);
            unset($_SESSION['senha']);
            header('Location: index.php');
        } else{
            // carrega informações de usuário em variáveis globais
            $_SESSION['usuario']      = $user;
            $_SESSION['senha']        = $pass;
            $_SESSION['nomeUser']     = $nome['NOME_FUNCIONARIO'];
            $_SESSION['credencial']   = $nome['CREDENCIAL'];
            $_SESSION['departamento'] = $nome['DEPARTAMENTO'];

            $dLogin   = date('Y-m-d');
            $hLogin   = date('H:i:s');
            $nomeUser = $nome['NOME_FUNCIONARIO'];

            $_SESSION['dataLogin'] = $dLogin;
            $_SESSION['horaLogin'] = $hLogin;
            
            // faz o registro de Login no histórico
            $LoginReg = mysqli_query($conectDB, "INSERT INTO historico_login(NOME_FUNCIONARIO, DATA_LOGIN, HORA_LOGIN) 
                        VALUES ('$nomeUser', '$dLogin', '$hLogin')");

            if($nome['CREDENCIAL'] >= 5){
                header('Location: P11MenuAdmin.php');
            } else if($nome['CREDENCIAL'] == 2 && $nome['DEPARTAMENTO'] == 'GARANTIA DE QUALIDADE'){
                header('Location: P21MenuGQ.php');
            } else if($nome['CREDENCIAL'] == 2 && $nome['DEPARTAMENTO'] == 'LOGÍSTICA'){
                header('Location: P90MenuLog.php');
            } else if($nome['CREDENCIAL'] == 2 && $nome['DEPARTAMENTO'] == 'PRODUÇÃO'){
                header('Location: P91MenuProd.php');
            } else if($nome['CREDENCIAL'] < 2){
                header('Location: P04LogOut.php');
            }            
        }
      } else{
        // Não acessa
        header('Location: P04LogOut.php');
    }
