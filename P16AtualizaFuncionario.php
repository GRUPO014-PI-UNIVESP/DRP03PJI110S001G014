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
    $consulta = "SELECT * FROM funcionario ORDER BY CARGO, NOME_FUNCIONARIO ASC";
    $lista    = $conectDB->query($consulta) or die();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Funcionários</title>
</head>
<style>
    body{background-color:mediumseagreen; font-family:Arial, Helvetica, sans-serif; color:whitesmoke; font-size: 12px;}
    table, td, th{border: 1px solid lightslategray; border-collapse:collapse; font-size:12px;}
    thead, tbody{display:block;}
    tbody{overflow-y:scroll; height: 580px;}
    .mainBox{position: absolute; background-color: rgba(0, 0, 0, 0.5); width:95%;height: 90%;top: 50%; left: 50%;transform: translate(-50%, -50%);padding: 5px; font-size: 12px;}
    .topoLinha{width: 100%; height: 30px; padding: 2px;}
    .coluna1{width: 12%; height: 30px; float: left;}
    .coluna2{width: 18%; height: 30px; float: left;}
    .coluna3{width: 45%; height: 30px; float: left;}
    .coluna4{width: 20%; height: 30px; float: left;}
    .b1{background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px;float: left;cursor:pointer; border-radius:5px;}
    .b1:hover{background-color: blue;} 
    .b2{background-color: dodgerblue; width:180px; border:none; padding:8px; color:white; font-size:14px;float: right;cursor:pointer; border-radius:10px;}
    .b2:hover{background-color: crimson;}   
</style>
<body>
    <br><br>
    <div class="mainBox">
        <div class="topoLinha">
            <div class="coluna1"><br> 
                <label style="text-align:right; font-size: 14px;" for="">Ordenar lista por:</label>
            </div>
            <div class="coluna2">   
                <input class="b1" type="submit" id="" name="" value="Departamento" onclick="location.href='P15AtualizaFuncionario.php'">
            </div> 
            <div class="coluna3">   
                <input class="b1" type="submit" id="" name="" value="Cargo"        onclick="location.href='P16AtualizaFuncionario.php'"> 
            </div> 
            <div class="coluna4">   
                <input class="b2" type="reset" value="Voltar" id="botao" style="text-align:center" onclick="location.href='P11MenuAdmin.php'">
            </div> 
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width:090px; height:35px">ID Registro</th>
                    <th style="width:425px; height:35px">Nome Completo</th>
                    <th style="width:175px; height:35px">Departamento</th>
                    <th style="width:175px; height:35px">Cargo/Função</th>
                    <th style="width:175px; height:35px">Atualização</th>
                </tr>
            </thead>
            <tbody>
                <?php while($dado = $lista->fetch_array()) { ?> 
                <tr>
                    <td style="font-size: 12px; height:45px; width: 090px; text-align:center;"> <?php echo $dado['ID_FUNCIONARIO'];?> </td> 
                    <td style="font-size: 12px; height:45px; width: 425px"                    > <?php echo $dado['NOME_FUNCIONARIO']; ?> </td>
                    <td style="font-size: 12px; height:45px; width: 175px"                    > <?php echo $dado['DEPARTAMENTO'];?> </td>
                    <td style="font-size: 12px; height:45px; width: 175px"                    > <?php echo $dado['CARGO'];?> </td>
                    <td style="text-align:center; font-size:12px; width: 175px; height:45px;">
                        <input type="submit" id="editar" name="editar" value="Editar" 
                                onclick="location.href='P17AtualizaFuncionario.php?id=<?php echo $dado['ID_FUNCIONARIO']?>'">
                        <input type="submit" id="excluir" name="excluir" value="Excluir"
                                onclick="location.href='P18ExclusaoFuncionario.php?id=<?php echo $dado['ID_FUNCIONARIO']?>'">
                    </td>
                </tr> 
                <?php } ?>
            </tbody>
        </table>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>