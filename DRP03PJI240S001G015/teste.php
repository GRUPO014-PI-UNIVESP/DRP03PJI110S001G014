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
      $funcionario     = $nome['NOME_FUNCIONARIO'];
      $credencial   = $nome['CREDENCIAL'];
      $departamento = $nome['DEPARTAMENTO'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<p>Clique para exibir.</p>

<button onclick="myFunction()">Clique aqui</button>

<p id="demo"></p>

<script>
function myFunction()
{
var x;

var idade=prompt("Digite sua idade:");

if (idade!=null)
  {
  x="Idade: " + idade + " anos.";
  document.getElementById("demo").innerHTML=x;
  }
}
</script>
</body>
</html>