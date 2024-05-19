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
    $nLote  = ''; $encontrado = ''; $buscaLote  = ''; $tipo = ''; $dOrder = ''; $descr = ''; $qTotal = ''; $qAmostra = '';
    $dPrazo = ''; $dOrdem     = ''; $dPrazof    = '';

    $consulta1 = "SELECT * FROM ordem_servico WHERE SITUACAO = 'AGUARDANDO' ORDER BY DATA_PRAZO ASC";
    $consulta2 = "SELECT * FROM ordem_servico WHERE SITUACAO = 'CONCLUIDO' ORDER BY DATA_CONCLUSAO DESC";
    $lista1    = $conectDB->query($consulta1) or die();
    $lista2    = $conectDB->query($consulta2) or die();

    if(isset($_POST['consumo'])){

        $consumo = (int) $_POST['consumo'];
        $estoque = (int) $_SESSION['stkReag'];
        $qtdeLOT = (int) $_SESSION['qtdeReag'];

        if($consumo > $qtdeLOT){
            echo 'A quantidade inserida é superior à quantidade restante deste lote, favor inserir somente um valor inferior e atribuir o resto a outro lote';
        } else{
            $calculaLote = $qtdeLOT - $consumo;
            $calculaStck = $estoque - $consumo;
            $loteA = $_SESSION['numeroLote'];
            $loteR = $_SESSION['loteReag'];
            $descR = $_SESSION['dscReag'];
            $cotaR = $_SESSION['cotReag'];
            $margem = (double) $calculaStck / $cotaR;
            if($margem > 2){
                $cond = 'Estável';
                $cor  = 'green';
            } else if(($margem > 1.25) && ($margem < 2)){
                $cond = 'Alerta';
                $cor  = 'Orange';
            } else if($margem < 1.25){
                $cond = 'Crítico';
                $cor  = 'red';
            }
        }

        $registra1 = mysqli_query($conectDB, "INSERT INTO lista_provisoria(LOTE_AMOSTRA, LOTE_REAGENTE, DESCRICAO_REAGENTE, CONSUMO, Q_LOTE, T_ESTOQUE) 
                                                VALUES ('$loteA', '$loteR', '$descR', '$consumo', '$calculaLote', '$calculaStck')");

        $atualizaEstoque = mysqli_query($conectDB, "UPDATE reagentes_estoque SET QTDE_ESTOQUE   = '$calculaStck' WHERE DESCR_REAGENTE = '$descR'");
        $atualizaLote    = mysqli_query($conectDB, "UPDATE reagentes_lotes   SET QTDE_LOTE      = '$calculaLote' WHERE NUMERO_LOTE    = '$loteR'");

        $sqlBuscaR = "SELECT * FROM lista_provisoria WHERE LOTE_AMOSTRA = '$loteA' ORDER BY DESCRICAO_REAGENTE ASC";
        $sqlLista  = $conectDB->query($sqlBuscaR) or die();
    }
    
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GQ | Análises</title>
    <script>
            function checksInput() {
                const input = document.getElementById("aciona");
                const form = document.getElementById("formulario");
                    if (input.value.length > 5) {
                        form.submit();
                    }
            }
            document.getElementById("code").oninput = checksInput;
    </script>
</head>
<style>
body{background-color:mediumseagreen; font-family:Arial, Helvetica, sans-serif; color:whitesmoke; font-size: 12px;}
table, td, th{border: 1px solid lightslategray; border-collapse:collapse; font-size:12px;}
thead, tbody{display:block;}
tbody{overflow-y:scroll; height:150px;}

.main{position:absolute; background-color:rgba(0, 0, 0, 0.5); width:98%; height:90%; top:50%; left:50%; transform:translate(-50%, -50%);}
.principal{width: 65%; height:96% ; float:left; padding:2px; font-size:14px;}

.pLinha1L {width:32%; height:40px; float:left; padding:2px;}
.pLinha1M {width:32%; height:40px; float:left; padding:2px;}
.pLinha1R {width:32%; height:40px; float:left; padding:2px;}
.pLinha2L {width:98%; height:40px; float:left; padding:2px;}
.pLinha3L {width:32%; height:40px; float:left; padding:2px;}
.pLinha3M {width:32%; height:40px; float:left; padding:2px;}
.pLinha3R {width:32%; height:40px; float:left; padding:2px;}
.pLinha4L {width:98%; height:05px; float:left; padding:2px;}
.pLinha5L {width:32%; height:40px; float:left; padding:2px;}
.pLinha5M {width:32%; height:40px; float:left; padding:2px;}
.pLinha5R {width:32%; height:40px; float:left; padding:2px;}
.pLinha6L {width:63%; height:40px; float:left; padding:2px;}
.pLinha6R {width:32%; height:40px; float:left; padding:2px;}
.pLinha7L {width:32%; height:40px; float:left; padding:2px;}
.pLinha7M {width:32%; height:40px; float:left; padding:2px;}
.pLinha7R {width:32%; height:40px; float:left; padding:2px;}
.pLinha8L {width:32%; height:40px; float:left; padding:2px;}
.pLinha8M {width:32%; height:40px; float:left; padding:2px;}
.pLinha8R {width:32%; height:40px; float:left; padding:2px;}
.pLinha9L {width:30%; height:40px; float:left; padding:2px;}
.pLinha9M {width:30%; height:40px; float:left; padding:2px;}
.pLinha9R {width:30%; height:40px; float:left; padding:2px;}
.pLinha00 {width:1040px; height:05px; float: left; padding:2px;}

.tabela1{width:33%; height:30%; float:right; padding:9px;}
.tabela2{width:33%; height:30%; float:right; padding:9px;}
.tabela3{width:1040px; height:30%; float:left; padding:9px;}
.rodape {width:100%; height:4%; float:left;}

.inputBox  {position:relative;}
.inputUser {background:none; border:none; border-bottom:1px solid lightsteelblue; outline:none; color:white; font-size:13px; width:98%; letter-spacing:2px;}
.labelInput{position:absolute; top:0px; left:0px; pointer-events:none; transition:.5s;}
.inputUser:focus ~ .labelInput,
.inputUser:valid ~ .labelInput{top:-12px; font-size:10px; color:bisque;}

#submit1      {background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px; cursor:pointer; border-radius:10px;}
#submit1:hover{background-color: darkblue;}
#submit2      {background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px; cursor:pointer; border-radius:10px;}
#submit2:hover{background-color: crimson;}
#modal{width: 700px;height: 700px;background-color: #fff;border-radius: 5px;padding: 20px;}
.b2      {background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px; cursor:pointer; border-radius:10px;}
.b2:hover{background-color: crimson;}   
</style>
<body>
    <div class="main">
        <div class="principal">
            <fieldset>
                <Legend style="font-size:15px; color:yellow">Dados da Amostra</Legend>        
                <div class="pLinha1L">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="nLote" name="nLote" style="text-transform: uppercase; text-align:center" value="<?php echo $_SESSION['numeroLote'] ?>">
                        <label class="labelInput" for="nLote" >Número do Lote</label>
                    </div>
                </div>
                <div class="pLinha1M">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="tipoAm" name="tipoAm" value="<?php echo $_SESSION['tipoAmostra'] ?>" style="text-align:center">
                        <label class="labelInput" for="tipoAm" >Tipo da Amostra</label>
                    </div>
                </div>
                <div class="pLinha1R">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="dLote" name="dLote" value="<?php echo date('d/m/Y', $_SESSION['dataOrdemBR']) ?>" style="text-align:center">
                        <label class="labelInput" for="dLote" >Data da Ordem</label>
                    </div>
                </div>
                <div class="pLinha2L">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="descr" name="descr" value="<?php echo $_SESSION['descrAmostra'] ?>" style="font-size:10px">
                        <label class="labelInput" for="descr" >Descrição da Amostra</label>
                    </div>
                </div>
                <div class="pLinha3L">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="number" id="qtdeTtl" name="qtdeTtl" value="<?php echo $_SESSION['qtdeLote'] ?>" style="text-align:right">
                        <label class="labelInput" for="qtdeTtl" >Quantidade do Lote (kg)</label>
                    </div>
                </div>
                <div class="pLinha3M">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="number" id="qtdeAmostra" name="qtdeAmostra" value="<?php echo $_SESSION['qtdeAmostra'] ?>" style="text-align:right">
                        <label class="labelInput" for="qtdeAmostra" >Quantidade de Amostras (unidades)</label>
                    </div>
                </div>
                <div class="pLinha3R">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="dPrazo" name="dPrazo" value="<?php echo date('d/m/Y', $_SESSION['dataPrazoBR']) ?>" style="text-align:center">
                        <label class="labelInput" for="dPrazo" >Prazo para Conclusão</label>
                    </div>
                </div>
            </fieldset> 
            <div class="pLinha4L"><br></div>
            <fieldset>
                <Legend style="font-size:15px; color:yellow">Dados do Reagente</Legend> 
                <div class="pLinha5L">
                    <br>
                    <div class="inputBox">
                        <input class="inputUser" type="text" id="codReag" name="codReag" style="text-transform: uppercase;text-align:center" value="<?php echo $_SESSION['codReag'] ?>">
                        <label class="labelInput" for="codReag" >Código do Reagente</label>
                    </div>
                </div>
                <div class="pLinha5M">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="loteReag" name="loteReag" style="text-transform: uppercase;text-align:center" value="<?php echo $_SESSION['loteReag'] ?>">
                            <label class="labelInput" for="loteReag" >Lote do Reagente</label>
                    </div>
                </div>
                <div class="pLinha5R">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="dataVali" name="dataVali" style="text-align:center"value="<?php echo $_SESSION['validade'] ?>">
                            <label class="labelInput" for="mkrReag" >Data de Validade</label>
                    </div>
                </div>
                <div class="pLinha6L">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="descrReag" name="descrReag" style="text-transform: uppercase; font-size: 10px" value="<?php echo $_SESSION['dscReag'] ?>">
                            <label class="labelInput" for="descrReag" >Descrição do Reagente</label>
                    </div>
                </div>
                <div class="pLinha6R">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="mkrReag" name="mkrReag" style="text-transform: uppercase; font-size:10px" value="<?php echo $_SESSION['mkrReag'] ?>">
                            <label class="labelInput" for="mkrReag" >Marca / Fornecedor</label>
                    </div>
                </div>
                <div class="pLinha7L">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="cota" name="cota" style="text-align:right" value="<?php echo $_SESSION['cotReag'] . $_SESSION['uniReag'] ?>">
                            <label class="labelInput" for="loteReag" >Cota de Segurança</label>
                    </div>
                </div> 
                <div class="pLinha7M">
                    <br>
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="stkReag" name="stkReag" style="text-align:right" value="<?php echo $_SESSION['stkReag'] . $_SESSION['uniReag'] ?>">
                            <label class="labelInput" for="stkReag" >Total em Estoque</label>
                    </div>
                </div> 
                <div class="pLinha7R">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="qtdeLote" name="qtdeLote" style="text-align:right" value="<?php echo $_SESSION['qtdeReag'] . $_SESSION['uniReag'] ?>">
                            <label class="labelInput" for="qtdeLote" >Quantidade do Lote</label>
                    </div>
                </div>
                <div class="pLinha8L">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="consumo" name="consumo" style="text-align:right" value="<?php echo $consumo . $_SESSION['uniReag'] ?>"> 
                            <label class="labelInput" for="consumo" >Quantidade Consumida</label>
                    </div>
                </div>
                <div class="pLinha8M">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="rstEstoque" name="rstEstoque" style="text-align:right" value="<?php echo $calculaLote . $_SESSION['uniReag'] ?>">
                            <label class="labelInput" for="rstEstoque" >Quantidade Restante do Lote</label>
                    </div>
                </div>
                <div class="pLinha8R">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="rstLote" name="rstLote" style="text-align:right" value="<?php echo $calculaStck . $_SESSION['uniReag'] ?>">
                            <label class="labelInput" for="rstLote" >Quantidade Restante em Estoque</label>
                    </div>
                </div>
                <div class="pLinha9L">
                    <br>
                    <input type="reset" id="submit1" name="continua" value="Próximo Reagente" onclick="location.href='P32RegistroAnalise.php'">
                </div> 
                <div class="pLinha9M">
                    <br>
                    <input type="reset" id="submit2" name="finaliza" value="Finalizar Ordem de Serviço" onclick="location.href='P35RegistroAnalise.php'">
                </div>
                <div class="pLinha9R">
                    <br>
                    <input class="b2" type="reset" value="Voltar" id="botao" onclick="location.href='P20MenuGQ.php'">  
                </div>       
            </fieldset>
            <div class="pLinha00"></div> 
            <div class="tabela3">
                <table>
                    <thead>
                        <tr>
                            <th style="width:110px;">Lote Amostra</th>
                            <th style="width:110px;">Lote Reagente</th>
                            <th style="width:340px;">Descrição do Reagente</th>
                            <th style="width:110px;">Consumo</th>
                            <th style="width:110px;">Qtde do Lote</th>
                            <th style="width:110px;">Total em Estoque</th>
                            <th style="width:110px;">Condição</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while($dado4 = $sqlLista->fetch_array()){ ?> 
                        <tr>
                            <td style="width:110; height: 15px; text-align:center;"><?php echo $dado4['LOTE_AMOSTRA'] ?></td>
                            <td style="width:110; height: 15px; text-align:center;"><?php echo $dado4['LOTE_REAGENTE'] ?></td>
                            <td style="width:340; height: 15px; text-align:left;"  ><?php echo $dado4['DESCRICAO_REAGENTE'] ?></td>
                            <td style="width:110; height: 15px; text-align:right;" ><?php echo (double)$dado4['CONSUMO'] ?></td>
                            <td style="width:110; height: 15px; text-align:right;" ><?php echo (double)$dado4['Q_LOTE'] ?></td>
                            <td style="width:110; height: 15px; text-align:right;" ><?php echo (double)$dado4['T_ESTOQUE'] ?></td>
                            <td style="width:110; height: 15px; text-align:center;
                                        background-color:lightcyan; color:<?php echo $cor ?>"><b><?php echo $cond ?></b></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div> 
        </div> 
        <div class="tabela1">
            <p style="text-align:center; font-size:14px">Amostras Aguardando Análise</p>
            <table>
                <thead>
                    <tr>
                        <th style="width:112px; height: 25px;">No.Lote</th>
                        <th style="width:112px; height: 25px;">Tipo</th>
                        <th style="width:112px; height: 25px;">Prazo</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($dado1 = $lista1->fetch_array()){ ?> 
                <tr>
                    <td style="font-size: 11px;width: 112px;text-align:center; height: 25px;"> <?php echo $dado1['NUMERO_LOTE'];?> </td>
                    <td style="font-size: 11px;width: 112px;text-align:center; height: 25px;"> <?php echo $dado1['TIPO_ANALISE']; ?> </td>
                    <td style="font-size: 11px;width: 112px;text-align:center; height: 25px;">
                        <?php
                            if($dado1['DATA_PRAZO'] != '0000-00-00'){
                                $dPz = $dado1['DATA_PRAZO']; 
                                $dPzBr = strtotime($dPz);
                                echo date('d/m/Y', $dPzBr);
                            }else{
                                echo '';
                            }
                        ?>
                    </td>
                </tr> 
                <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tabela2">
        <p style="text-align:center; font-size:14px">Análises Concluídas</p>
        <table>
                <thead>
                    <tr>
                        <th style="width:112px; height: 25px;">No.Lote</th>
                        <th style="width:112px; height: 25px;">Conclusão</th>
                        <th style="width:112px; height: 25px;">Responsável</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($dado2 = $lista2->fetch_array()){ ?> 
                <tr>
                    <td style="font-size: 11px;width: 114px;text-align:center; height: 25px;"> <?php echo $dado2['NUMERO_LOTE'];?> </td>
                    <td style="font-size: 11px;width: 114px;text-align:center; height: 25px;">
                        <?php
                            if($dado2['DATA_CONCLUSAO'] != '0000-00-00'){
                                $dcL = $dado2['DATA_CONCLUSAO']; 
                                $dcLBr = strtotime($dcL);
                                echo date('d/m/Y', $dcLBr);
                            }else{
                                echo '';
                            }
                        ?>
                    </td>
                    <td style="font-size: 11px;text-align:center;width: 114px; height: 25px;"> <?php echo $dado2['RESPONSAVEL'];?> </td>
                </tr> 
                <?php } ?>
                </tbody>
            </table>
        </div>    
        <div class="rodape">
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p> 
        </div>          
    </div>
</body>
</html>