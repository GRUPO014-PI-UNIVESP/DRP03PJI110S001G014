<?php
    // Programa      : P11MenuAdmin.php
    // Funcionalidade: seletor de ambiente de trabalho do sistema 

    include('P01ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)) { session_start(); }

    $dia = strtotime($_SESSION['dataLogin']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
      die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Ir para Login</a>"');    
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Main</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="CSS/index.css">
  <link rel="stylesheet" href="CSS/P11.css">
</head>

<script src="https://kit.fontawesome.com/0c6315cc4a.js" crossorigin="anonymous"></script>

<body>
  <!-- Barra lateral Superior-->
  <div class="sidebarTop">
    <p style="text-align: center; font-size: 15px">Departamentos</p>
    <a href="P12Administracao.php"><i class="fa fa-fw fa-building">                </i> Administração</a>
    <a href="P13GQualidade.php">   <i class="fa fa-fw fa-microscope">              </i> Garantia da Qualidade</a>
    <a href="P14Logistica.php">    <i class="fa fa-fw fa-truck-fast">              </i> Logística</a>
    <a href="P15Producao.php">     <i class="fa fa-fw fa-industry">                </i> Produção</a>
    <a href="P04Logout.php">       <i class="fa fa-fw fa-arrow-right-from-bracket"></i> Sair do Sistema</a>
  </div>
  <!-- Barra lateral Inferior-->
  <div class="sidebarBottom"><br>
    <div class="tab0"> <p style="text-align: center; font-size: 15px">Informações do Usuário</p> </div> <br><br>
    <div class="tab0"> <p>Nome do Usuário:</p>                                                   </div>
    <div class="tab1"> <p style="width: 198px; height: 30px; font-size: 10px"> <?php echo ($_SESSION['nomeUser']); ?></p> </div><br>
    <div class="tab0"> <p>Data de Login:</p>                                                     </div>
    <div class="tab1"> <p> <?php echo (date('d/m/Y', $dia)); ?></p>                              </div><br>
    <div class="tab0"> <p>Hora:</p>                                                              </div>
    <div class="tab1"> <p> <?php echo (date($_SESSION['horaLogin'])); ?></p>                     </div><br>
      <a href=""><i class="fa fa-fw fa-envelope"></i> Mensagens</a>
      <a href=""><i class="fa fa-fw fa-key"></i> Alterar Senha</a>
      <a href=""><i class="fa fa-fw fa-user"></i> Atualizar Dados Pessoais</a>
      <br><br><br><br><br><br>
      <p style="font-size:9px; color:bisque;text-align: center;">Developed by DRP03PJI240S001G015 2024</p>
    </div>
  </div>
  <div class="main">
  <p style="text-align: center; font-size: 25px; color: yellow">Selecione o ambiente de trabalho na barra lateral</p>
  <img src="Abertura.jpg" width="600" height="400" style="margin: 100px 100px "/>
  <p style="text-align: center; font-size: 30px; color: yellow">Tenha um bom dia.</p>
  </div>
</body>
</html>