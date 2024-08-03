
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesquisar</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  
  <body>

    <div class="container">
      <h1 class="mt-4 mb-4">Pesquisar</h1>
    </div>

      <form class="mb-4" method="POST" id="pesq-produto-form" action="">

        <div class="col-12 mb-2">
          <input type="text" name="produto" class="form-control" id="produto" placeholder="digitar palavra" onkeyup="carregar_produtos(this.value)">
          <span id="resultado_pesquisa"></span>
        </div>

        <div class="col-12">
          <button class="btn btn-success" type="submit">Pesquisar</button>
        </div>

      </form>

      <span id="listar_produtos"></span>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
      </script>
      <script src="js/custom.js">
      </script>
  </body>
</html>