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
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Main</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<style>
  body{
    background-color: rgba(25, 170, 150, 0.8);
    font-family: Arial, Helvetica, sans-serif;
    color: whitesmoke;
  }
  /* Style the sidebar - fixed full height */
  .sidebar {
    height: 50%;
    width: 200px;
    position: fixed;
    z-index: 1;
    top: 0;
    left: 0;
    background-color: rgba(80, 75, 75);
    overflow-x: hidden;
    padding-top: 10px;
  }
  .sidebarB{
    height: 50%;
    width: 200px;
    position: fixed;
    top: 50%;
    left: 0;
    background-color: rgba(80, 75, 75);
    overflow-x: hidden;
    padding-top: 5px;
    font-size: 11px;
  }
  /* Style sidebar links */
  .sidebar a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 13px;
    color: whitesmoke;
    display: block;
  }
  .main a {
    padding: 6px 8px 6px 16px;
    text-decoration: none;
    font-size: 25px;
    color: whitesmoke;
    display: block;
  }
  /* Style links on mouse-over */
  .sidebar a:hover {
    color:aqua;
  }

  /* Style the main content */
  .main {
    margin-left: 210px; /* Same as the width of the sidenav */
    padding: 10px;
  }
    /* Style links on mouse-over */
    .main a:hover {
    color:aqua;
  }

  /* Add media queries for small screens (when the height of the screen is less than 450px, add a smaller padding and font-size) */
  @media screen and (max-height: 450px) {
    .sidebar {padding-top: 15px;}
    .sidebar a {font-size: 18px;}
  }
  fieldset{
    border-radius: 10px;
    
  }
  legend{
    text-align: center;
    font-size: 25px;
    
  }
</style>

<body>
  <!-- Sidebar -->
  <div class="sidebar">
    <a href="P12Administracao.php"><i class="fa fa-fw fa-building">                </i> Administração</a>
    <a href="P13GQualidade.php">   <i class="fa fa-fw fa-microscope">              </i> Garantia da Qualidade</a>
    <a href="P14Logistica.php">    <i class="fa fa-fw fa-truck-fast">              </i> Logística</a>
    <a href="P15Producao">         <i class="fa fa-fw fa-industry">                </i> Produção</a>
    <a href="P04Logout.php">       <i class="fa fa-fw fa-arrow-right-from-bracket"></i> Sair do Sistema</a>
  </div>
  <div class="sidebarB">
    <p> <?php echo (' Logado em:  ' . date('d/m/Y', $dia) . ' ' . $_SESSION['horaLogin']); ?></p>
    <p> <?php echo (' Usuário:    ' . $_SESSION['nomeUser']); ?></p>
    <a href=""><i class="fa fa-fw fa-key"></i> Alterar Senha</a>
    
  </div>
  <script src="https://kit.fontawesome.com/0c6315cc4a.js" crossorigin="anonymous"></script>

  <div class="main">
    <fieldset>
      <legend>Quadro de Funcionarios</legend>
      <a href=""><i class="fa-solid fa-users">    </i> Cadastro de Novos Funcionários</a>
      <a href=""><i class="fa-solid fa-pen-fancy"></i> Alterar Dados Cadastrais</a>
      <a href=""><i class="fa-solid fa-file">     </i> Histórico de Login no Sistema</a>
    </fieldset>
  </div>
</body>
</html>