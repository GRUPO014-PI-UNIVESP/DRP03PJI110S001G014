<?php
  include_once './conexao.php';

  $nome_produto = filter_input(INPUT_GET, "nome", FILTER_DEFAULT);

  if(!empty($nome_produto)){

    $pesq_produto    = "%" . $nome_produto . "%";
    $query_produtos  = "SELECT id, nome FROM produtos WHERE nome LIKE :nome  LIMIT 10 ";
    $result_produtos = $conn->prepare($query_produtos);
    $result_produtos->bindParam(':nome', $pesq_produto);
    $result_produtos->execute();

    if(($result_produtos) and ($result_produtos->rowCount() != 0)){

      while($row_produto = $result_produtos->fetch(PDO::FETCH_ASSOC)){
        
        $dados[] = [
          "id"   => $row_produto['id'],
          "nome" => $row_produto['nome']
        ];
      }
      $retorna = ['status' => true, 'dados' => $dados];
    }else{
      $retorna = ['status' => false, 'msg' => "Erro: nada "];
    }

  }else{
    $retorna = ['status' => false, 'msg' => "Erro: nada "];
  }

  echo json_encode($retorna);