<?php
    include('P01ConectDB.php');

    //definição de hora local
    date_default_timezone_set('America/Sao_Paulo');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){
        session_start();
    }
    $dia = strtotime($_SESSION['dataLogin']);
    //echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);

    //se sessão não tem usuário logado, redireciona para a página de Login
    if(!isset($_SESSION['usuario'])){
        die('Você não está autorizado a acessar a página, pois não está LOGADO "<a href="index.php">Entrar</a>"');    
    }
    if($_SESSION['credencial'] < 5 && $_SESSION['departamento'] != 'ADMINISTRAÇÃO'){
        header('Location: P09Mensagem.php');
    }
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema</title>
  </head>
  <style>
    body{background-color: rgba(25, 170, 150, 0.8);
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    color: whitesmoke;
    }
    /* The sidebar menu */
    .sidenav {
      height: 100%;
      width: 165px;
      position: fixed;
      z-index: 1;
      top: 0;
      left: 0;
      background-color: rgba(80, 75, 75);
      overflow-x: hidden;
      padding-top: 12px;
    }

    /* The navigation menu links */
    .sidenav a {
      padding: 6px 8px 6px 16px;
      text-decoration: none;
      font-size: 12px;
      color: whitesmoke;
      display: block;
    }

    /* When you mouse over the navigation links, change their color */
    .sidenav a:hover {
      color:cyan;
      font-size: 13px;
    }

    /* Style page content */
    .main {
      margin-left: 155px;
      padding: 0px 6px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidebar (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
      .sidenav {padding-top: 15px;}
      .sidenav a {font-size: 18px;}
    }
  </style>
  <body>
    <!-- Side navigation -->
    <div class="sidenav">
      <a href="P12Administracao.php">Administração</a>
      <a href="P13GQualidade.php">Garantia da Qualidade</a>
      <a href="P14Logistica.php">Logística</a>
      <a href="P15Producao.php">Produção</a>
      <a href="P04Logout.php">Sair do Sistema</a>
    </div>

    <!-- Page content -->
    <div class="main">
    <p><?php echo ('Logado: ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin'] . ' '. $_SESSION['nomeUser']);?></p>
    </div>
  </body>
</html>