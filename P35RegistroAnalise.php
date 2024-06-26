<?php
    include('P01ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}
    $dia = strtotime($_SESSION['dataLogin']);
    echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');}

    $amostra     = $_SESSION['numeroLote'];
    $responsavel = $_SESSION['nomeUser'];
    $dataconclusao = date('Y-m-d', strtotime($_SESSION['dataLogin']));


    $sqlLista  = "SELECT * FROM lista_provisoria WHERE LOTE_AMOSTRA = '$amostra' ORDER BY LOTE_REAGENTE ASC";
    $transfer  = $conectDB->query($sqlLista) or die();
    $comutador = $transfer->fetch_assoc();

    $loteA     = $comutador['LOTE_AMOSTRA'];


        $alteraSituação  = mysqli_query($conectDB, "UPDATE ordem_servico SET DATA_CONCLUSAO = '$dataconclusao', SITUACAO = 'CONCLUIDO',
                                                    RESPONSAVEL = '$responsavel' WHERE NUMERO_LOTE = '$loteA'");
    header('Location: P31RegistroAnalise.php');

?>
