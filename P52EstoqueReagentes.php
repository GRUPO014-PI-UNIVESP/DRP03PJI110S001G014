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
    $sqlEstoque = "SELECT * FROM reagentes_estoque WHERE QTDE_ESTOQUE > 0 ORDER BY QTDE_ESTOQUE ASC";
    $listaEstoque = $conectDB->query($sqlEstoque) or die();
    $sit1 = 'font-size: 12px; width: 120px; height: 30px; text-align:center; background-color:green; color:whitesmoke';
    $sit2 = 'font-size: 12px; width: 120px; height: 30px; text-align:center; background-color:orange; color:black';
    $sit3 = 'font-size: 12px; width: 120px; height: 30px; text-align:center; background-color:red; color:yellow';
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
        <p style="text-align:center; font-size:16px; ">Estoque de Reagentes</p>
        <table >
            <thead>
                <tr>
                    <th style="width: 090px; font-size: 12px; ">Código do Reagente</th>
                    <th style="width: 480px; font-size: 12px; ">Descrição do Reagente</th>
                    <th style="width: 120px; font-size: 12px; ">Situação</th>
                    <th style="width: 120px; font-size: 12px; ">Quantidade em Estoque</th>
                    <th style="width: 050px; font-size: 12px; ">Unidade</th>
                    <th style="width: 090px; font-size: 12px; ">Cota de Segurança</th>
                </tr>
            </thead>
            <tbody>
                <?php while($dado1 = $listaEstoque->fetch_array()) { ?> 
                <tr>
                    <td style="font-size: 12px; width: 090px; height: 30px; text-align:center;"> <?php echo $dado1['CODIGO_REAGENTE'];?> </td> 
                    <td style="font-size: 12px; width: 480px; height: 30px;"                   > <?php echo $dado1['DESCR_REAGENTE']; ?> </td>
                    <?php
                        switch($dado1['SITUACAO']){
                            case strtoupper('ESTÁVEL'): $condicao = $sit1; break;
                            case strtoupper('ALERTA'):  $condicao = $sit2; break;
                            case strtoupper('CRÍTICO'): $condicao = $sit3; break;
                        }
                    ?>
                    <td style="<?php echo $condicao ?>"> <?php echo $dado1['SITUACAO'];?> </td>
                    <td style="font-size: 17px; width: 120px; height: 30px; text-align:center;"> <?php echo $dado1['QTDE_ESTOQUE'];?> </td>
                    <td style="font-size: 12px; width: 050px; height: 30px; text-align:center;"> <?php echo $dado1['UNIDADE'];?> </td>
                    <td style="font-size: 12px; width: 090px; height: 30px; text-align:center;"> <?php echo $dado1['COTA_LIMITE'];?> </td>
                </tr> 
                <?php } ?>
            </tbody>
        </table>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>