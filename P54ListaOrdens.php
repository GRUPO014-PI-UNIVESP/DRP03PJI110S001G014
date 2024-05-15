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
    $sqlOrdem = "SELECT * FROM ordem_servico WHERE SITUACAO = 'AGUARDANDO' ORDER BY DATA_PRAZO ASC";
    $listaOrdem = $conectDB->query($sqlOrdem) or die();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GQ | Relatórios</title>
</head>
<style>
    body{background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; color: whitesmoke; font-size: 12px;}
    .mainBox{background-color: rgba(0, 0, 0, 0.5); position: absolute; width: 96%; height: 90%; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 5px;}
    .topolinha{width: 100%; height: 30px;}
    .botao{width: 19.5%; height: 35px; font-size: 14px; background-color: dodgerblue; color: whitesmoke; border-radius: 4px;}
    .botao:hover{background-color: crimson; font-size: 15px;}

    table, td, th{padding: 5px; border: 1px solid lightgreen; border-collapse: collapse;}
    thead, tbody{display: block;}
    tbody{overflow-y: scroll; height: 90%;}
</style>
<body>
    <div class="mainBox">
        <div class="topolinha">
            <input class="botao" type="button" id="" name="" value="Estoque de Reagentes"          onclick="location.href='P52EstoqueReagentes.php'">
            <input class="botao" type="button" id="" name="" value="Lista dos Lotes de Reagentes"  onclick="location.href='P53ListaLotes.php'">
            <input class="botao" type="button" id="" name="" value="Lista de Ordens de Serviço"    onclick="location.href='P54ListaOrdens.php'">
            <input class="botao" type="button" id="" name="" value="Lista de Análises Concluídas"  onclick="location.href='P55ListaConcluidos.php'">
            <input class="botao" type="button" id="" name="" value="Voltar"                        onclick="location.href='P20MenuGQ.php'">
        </div>
        <br><br>
        <p style="text-align:center; font-size:16px; ">Lista de Ordens de Serviço Aguardando Análise</p>
        <table >
            <thead>
                <tr>
                    <th style="width: 100px; font-size: 12px; ">Codigo Amostra</th>
                    <th style="width: 590px; font-size: 12px; ">Descrição da Amostra</th>
                    <th style="width: 100px; font-size: 12px; ">Numero do Lote</th>
                    <th style="width: 120px; font-size: 12px; ">Quantidade do Lote</th>
                    <th style="width: 100px; font-size: 12px; ">Prazo para Conclusão</th>
                </tr>
            </thead>
            <tbody>
                <?php while($dado3 = $listaOrdem->fetch_array()) { ?> 
                <tr>
                    <td style="font-size: 12px; width: 100px; height: 30px; text-align:center;"> <?php echo $dado3['CODIGO_AMOSTRA'];?> </td> 
                    <td style="font-size: 12px; width: 590px; height: 30px;"                   > <?php echo $dado3['DESCRICAO_AMOSTRA']; ?> </td>
                    <td style="font-size: 12px; width: 100px; height: 30px; text-align:center;"> <?php echo $dado3['NUMERO_LOTE'];?> </td>
                    <td style="font-size: 12px; width: 120px; height: 30px; text-align:center;"> <?php echo $dado3['QTDE_LOTE'];?> </td>
                    <td style="font-size: 12px; width: 100px; height: 30px; text-align:center;"> <?php echo date('d/m/Y', strtotime($dado3['DATA_PRAZO']));?> </td>
                </tr> 
                <?php } ?>
            </tbody>
        </table>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>