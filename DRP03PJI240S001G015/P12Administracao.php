<?php
    // Programa      : P12Administração.php
    // Funcionalidade: seletor para tarefas de administração  

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
  // verificação de credencial de acesso
  $user = $_SESSION['usuario'];
  $pass = $_SESSION['senha'];

  $verifica  = "SELECT * FROM quadro_funcionarios WHERE ID_USUARIO = '$user' and SENHA_USUARIO = '$pass'";
  $resultado = $conectDB->query($verifica) or die("Falha na execução do código SQL");
  $nome      = $resultado->fetch_assoc();

    // carrega informações de usuário em variáveis globais
    $funcionario  = $nome['NOME_FUNCIONARIO'];
    $credencial   = $nome['CREDENCIAL'];
    $departamento = $nome['DEPARTAMENTO'];

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home | Main</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="CSS/P11.css">
  <link rel="stylesheet" href="CSS/P12.css">
</head>

<script src="https://kit.fontawesome.com/0c6315cc4a.js" crossorigin="anonymous"></script>

<body>
  <!-- Barra lateral Superior -->
  <div class="sidebarTop">
    <p style="text-align: center; font-size: 15px">Departamentos</p>
    <a href="P12Administracao.php"><i class="fa fa-fw fa-building">                </i> Administração</a>
    <a href="P13GQualidade.php">   <i class="fa fa-fw fa-microscope">              </i> Garantia da Qualidade</a>
    <a href="P14Logistica.php">    <i class="fa fa-fw fa-truck-fast">              </i> Logística</a>
    <a href="P15Producao.php">     <i class="fa fa-fw fa-industry">                </i> Produção</a>
    <a href="P04Logout.php">       <i class="fa fa-fw fa-arrow-right-from-bracket"></i> Sair do Sistema</a>
  </div>

  <!-- Barra lateral Inferior -->
  <div class="sidebarBottom">
    <br>
    <div class="tab0"> <p style="text-align: center; font-size: 15px">Informações do Usuário</p> </div>
    <br><br>
    <div class="tab0"> <p>Nome do Usuário:                              </p> </div>
    <div class="tab1"> <p> <?php echo ($_SESSION['nomeUser']); ?>       </p> </div><br>
    <div class="tab0"> <p>Data de Login:                                </p> </div>
    <div class="tab1"> <p> <?php echo (date('d/m/Y', $dia)); ?>         </p> </div><br>
    <div class="tab0"> <p>Hora:                                         </p> </div>
    <div class="tab1"> <p> <?php echo (date($_SESSION['horaLogin'])); ?></p> </div><br>
      <a href=""><i class="fa fa-fw fa-envelope"></i> Mensagens</a>
      <a href=""><i class="fa fa-fw fa-key">     </i> Alterar Senha</a>
      <a href=""><i class="fa fa-fw fa-user">    </i> Atualizar Dados Pessoais</a>
      <br><br><br><br><br><br><br>
      <p style="font-size:9px; color:bisque;text-align: center;">Developed by DRP03PJI240S001G015 2024</p>
    </div>

    <!-- Área Principal -->
    <div class="main">
      <p style="text-align: center; font-size: 30px">Administração</p>
      <!-- Botões Seletores -->
      <div class="frame">
        <button class="custom-btn btn-12" 
          <?php // verifica se credencial é válida para acesso
            if($departamento == 'ADMINISTRAÇÃO' && $credencial >= 5){?>  
              onclick="location.href='P20CadastroFuncionario.php'">
              <span>Clique e acesse!</span><span>Cadastro de Novo Funcionário</span></button><?php
            }
            if($departamento != 'ADMINISTRAÇÃO' && $credencial <=5){?>
              onclick="">
              <span style="font-size: 14px; color: yellow">Credencial sem permissão de acesso!</span><span>Cadastro de Novo Funcionário</span></button><?php
            }
          ?>
        <button class="custom-btn btn-12" 
          <?php // verifica se credencial é válida para acesso
            if($departamento == 'ADMINISTRAÇÃO' && $credencial >= 5){?>  
              onclick="location.href='P25AtualizaDados.php'">
              <span>Clique e acesse!</span><span>Atualização de Dados do Funcionário</span></button><?php
            }
            if($departamento != 'ADMINISTRAÇÃO' && $credencial <=5){?>
              onclick="">
              <span style="font-size: 14px; color: yellow">Credencial sem permissão de acesso!</span><span>Atualização de Dados do Funcionário</span></button><?php
            }
          ?>        
        <button class="custom-btn btn-12" onclick="location.href='P30QuadroGeral.php'">
          <span>Clique e acesse!</span><span>Quadro de Funcionários</span></button>
        
        <button class="custom-btn btn-12" onclick="location.href='P03HistoricoLogin.php'">
          <span>Clique e acesse!</span><span>Monitor de Login no Sistema</span></button><br><br>
      </div>
    </div>
</body>
</html>