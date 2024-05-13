<?php
    include('P01.ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){session_start();}
    $dia = strtotime($_SESSION['dataLogin']);
    echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');}
    $consulta = "SELECT * FROM registro_login ORDER BY DATA_LOGIN, HORA_LOGIN DESC";
    $lista    = $conectDB->query($consulta) or die();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Login</title>
</head>
<style>
    body{background-color: mediumseagreen; font-family: Arial, Helvetica, sans-serif; color: whitesmoke;}
    table, td, th{padding: 5px; border: 1px solid lightgreen; border-collapse: collapse;}
    thead, tbody{display: block;}
    tbody{overflow-y: scroll; height: 500px;}
    .mainBox{position: absolute; background-color: rgba(0, 0, 0, 0.5); width:80%; top: 50px; left: 100px; padding: 5px; font-size: 12px;}
</style>
<body>
    <div class="mainBox">
        <input type="reset" value="Voltar" onclick="location.href='P11.MenuAdmin.php'">
        <br>
        <br>
        <table >
            <thead>
                <tr>
                    <th style="width: 100px">LogIn</th>
                    <th style="width: 100px">Hora </th>
                    <th style="width: 400px">Usuário</th>
                    <th style="width: 100px">LogOut</th>
                    <th style="width: 100px">Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php while($dado = $lista->fetch_array()) { ?> 
                <tr>
                    <td style="font-size: 12px;text-align:center;width: 100px">
                        <?php 
                            $dIN = $dado['DATA_LOGIN']; 
                            $din = strtotime($dIN);
                            echo date('d/m/Y', $din);
                        ?>
                    </td>
                    <td style="font-size: 12px;text-align:center;width: 100px"> <?php echo $dado['HORA_LOGIN'];?> </td> 
                    <td style="font-size: 12px;width: 400px"                  > <?php echo $dado['USUARIO_LOGADO']; ?> </td>
                    <td style="font-size: 12px;text-align:center;width: 100px">
                        <?php
                            if($dado['DATA_LOGOUT'] != '0000-00-00'){
                            $dOUT = $dado['DATA_LOGOUT']; 
                            $dout = strtotime($dOUT);
                            echo date('d/m/Y', $dout);
                            }else{
                                echo '';
                            }
                        ?>
                    </td>
                    <td style="font-size: 12px;text-align:center;width: 100px"> <?php echo $dado['HORA_LOGOUT'];?> </td>
                </tr> 
                <?php } ?>
            </tbody>
        </table>
        <p style="font-size:9px; color:bisque;text-align: center;">Developed by EdsonmmInfo 2024</p>
    </div>
</body>
</html>