<?php
    include('P01ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}
    //exibição de logado no canto da tela
    $dia = strtotime($_SESSION['dataLogin']);
    echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
        die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');    
    }
    //inicialização de variáveis
    $nLote  = ''; $encontrado = ''; $buscaLote  = ''; $tipo = ''; $dOrder = ''; $descr = ''; $qTotal = ''; $qAmostra = '';
    $dPrazo = ''; $dOrdem     = ''; $dPrazof    = '';

    // busca de dados da ordem de serviço
    $consulta1 = "SELECT * FROM ordem_servico WHERE SITUACAO = 'AGUARDANDO' ORDER BY DATA_PRAZO ASC";
    $consulta2 = "SELECT * FROM ordem_servico WHERE SITUACAO = 'CONCLUIDO' ORDER BY DATA_CONCLUSAO DESC";
    $lista1    = $conectDB->query($consulta1) or die();
    $lista2    = $conectDB->query($consulta2) or die();

    // verifica codigo do reagente e numero de lote fornecido pelo usuário
    if(isset($_POST['codReag']) && isset($_POST['loteReag'])){
        $codReag       = $_POST['codReag'];
        $loteReag      = $_POST['loteReag'];
        $buscaReagente1 = "SELECT * FROM reagentes_estoque WHERE CODIGO_REAGENTE = '$codReag'";
        $buscaReagente2 = "SELECT * FROM reagentes_lotes   WHERE NUMERO_LOTE     = '$loteReag'";
        $sqlReagente1   = $conectDB->query($buscaReagente1) or die();
        $sqlReagente2   = $conectDB->query($buscaReagente2) or die();
        $Reagente1      = $sqlReagente1->fetch_assoc();
        $Reagente2      = $sqlReagente2->fetch_assoc();
        $verificaReag1  = mysqli_num_rows($sqlReagente1);
        $verificaReag2  = mysqli_num_rows($sqlReagente2);

        if(($verificaReag1 < 1) && ($verificaReag2 < 1)){
            echo 'Código do Reagente ou lote não encontrado, verifique!    ';
        } else{
            $_SESSION['codReag'] = $Reagente1['CODIGO_REAGENTE'];
            $_SESSION['mkrReag'] = $Reagente1['MARCA_REAGENTE'];
            $_SESSION['cotReag'] = $Reagente1['COTA_LIMITE'];
            $_SESSION['uniReag'] = $Reagente1['UNIDADE'];
            $_SESSION['dscReag'] = $Reagente1['DESCR_REAGENTE'];
            $_SESSION['stkReag'] = $Reagente1['QTDE_ESTOQUE'];
            $_SESSION['fpqReag'] = $Reagente1['FISPQ'];
            $fispq = 'FISPQfiles/' . $Reagente1['FISPQ'];

            $cota    = $Reagente1['COTA_LIMITE'] . $Reagente1['UNIDADE'];
            $estoque = $Reagente1['QTDE_ESTOQUE'] . $Reagente1['UNIDADE'];
            $lote    = $Reagente2['QTDE_LOTE'] . $Reagente1['UNIDADE'];

            $_SESSION['loteReag'] = $Reagente2['NUMERO_LOTE'];
            $_SESSION['valiReag'] = strtotime($Reagente2['DATA_VALI']);
            $_SESSION['qtdeReag'] = $Reagente2['QTDE_LOTE'];
            $_SESSION['validade'] = date('d/m/Y', $_SESSION['valiReag']);
            
        }
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
                            <input class="inputUser" type="text" id="dataVali" name="dataVali" value="<?php echo $_SESSION['validade'] ?>">
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
                            <input class="inputUser" type="text" id="cota" name="cota" style="text-align:right" value="<?php echo $cota ?>">
                            <label class="labelInput" for="loteReag" >Cota de Segurança</label>
                    </div>
                </div> 
                <div class="pLinha7M">
                    <br>
                    <div class="inputBox">
                    <input class="inputUser" type="text" id="stkReag" name="stkReag" style="text-align:right" value="<?php echo $estoque ?>">
                            <label class="labelInput" for="stkReag" >Total em Estoque</label>
                    </div>
                </div> 
                <div class="pLinha7R">
                    <br>
                    <div class="inputBox">
                            <input class="inputUser" type="text" id="qtdeLote" name="qtdeLote" style="text-align:right" value="<?php echo $lote?>">
                            <label class="labelInput" for="qtdeLote" >Quantidade do Lote</label>
                    </div>
                </div>
                <div class="pLinha8L">
                    <br>
                    <button class="b2" onclick="modal.showModal()">Consultar FISPQ</button>
                        <dialog id="modal">
                            <button class="b2" onclick="modal.close()">Fechar</button>
                            <embed src="<?php echo $fispq ?>" type="application/pdf" width="700px" height="700px"/>
                        </dialog>
                </div>
                <div class="pLinha8M">
                    <br>
                    <form action="P34RegistroAnalise.php" method="POST">
                        <div class="inputBox">
                            <input class="inputUser" type="number" id="consumo" name="consumo" style="text-align:right" onchange="this.form.submit()" required>
                            <label class="labelInput" for="consumo" >Quantidade Consumida <?php echo ' ' . $_SESSION['uniReag'] ?> </label>
                        </div>
                    </form>
                </div>
                <div class="pLinha8R">
                    <br>
                <input class="b2" type="reset" value="Cancelar" id="botao" onclick="location.href='P20MenuGQ.php'">
                </div>            
            </fieldset>
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