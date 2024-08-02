<?php
  // index.php
  // Programa de abertura do sistema pedindo usuário e senha

  //definição de hora local
  date_default_timezone_set('America/Sao_Paulo');

  //Chama conexão com banco de dados
  include_once './ConnectDB.php';

  if(!isset($_POST['submit']) && !empty($_POST['usuario']) && !empty($_POST['senha'])){

    $usuario = $_POST['usuario'];
    $senha   = $_POST['senha'];

      $search = "SELECT ID_USUARIO, SENHA_USUARIO FROM quadro_funcionarios WHERE ID_USUARIO = :usuario AND SENHA_USUARIO = :senha  LIMIT 1";
      $result = $connDB->prepare($search);
      $result->bindParam(':usuario', $usuario);
      $result->bindParam(':senha', $senha);
      $result->execute();

      if(($result) and ($result->rowCount() != 0)){
        $found = $result->fetch(PDO::FETCH_ASSOC);
        echo 'registro encontrado com sucesso';
      }else{
        echo "<p>Erro: dados incorretos</p>";
      }
  }
?>

<!doctype html>
<html lang="pt-br" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  </head>
  <body>
    <form method="POST" action="">
      <div class="container-fluid">
        <div class="col-3 mt-3 mb-3 mx-auto">
          <h1 style="text-align: center">Login</h1><br>
          <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
              </svg>
            </span>
            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Usuário" 
              maxlength="10" aria-label="Username" aria-describedby="addon-wrapping" require>
          </div>
          <br>
          <div class="input-group flex-nowrap">
            <span class="input-group-text" id="addon-wrapping">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
              </svg>   
            </span>
            <input type="text" id="senha" name="senha" class="form-control" placeholder="Senha de 6 dígitos" 
              maxlength="6" aria-label="Username" aria-describedby="addon-wrapping" require>
          </div>
          <br>
          <div class="d-grid gap-2">
          <input class="btn btn-primary" type="submit" id="submit" name="submit" value="Enviar">
          </div>
        </div>
      </div>
    </form>

     </body>
</html>