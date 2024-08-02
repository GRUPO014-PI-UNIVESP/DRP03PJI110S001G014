async function carregar_produtos(valor){
  if(valor.length >= 1){
    const dados    = await fetch('pesquisar_produtos.php?nome=' + valor);
    const resposta = await dados.json();
    console.log(resposta);

    var resultado = "<ul class='list-group position-fixed'>";

    if(resposta['status']){
      for(i = 0; i < resposta['dados'].length; i++){
        resultado += "<li class='list-group-item list-group-item-action' onclick='listar_produto(" 
        + JSON.stringify(resposta['dados'][i].nome) + ")'>" + resposta['dados'][i] . nome + "</li>";
      }
    }else{
      resultado += "<li class='list-group-item disabled'>" + resposta['msg'] + "</li>";
    }

    resultado += "</ul>";

    document.getElementById("resultado_pesquisa").innerHTML = resultado;
  }
}

const fechar = document.getElementById('produto');

document.addEventListener('click', function(event){
  const validar_clique = fechar.contains(event.target);

  if(!validar_clique){
    document.getElementById('resultado_pesquisa').innerHTML = '';
  }
  });

async function listar_produto(nome){
  console.log(nome);
  document.getElementById("produto").value = nome;

  const dados = await fetch('listar_produtos.php?nome=' + nome);
  const resposta = await dados.json();
  var produto = "";

  if(resposta['status']){
    for(i = 0; i < resposta['dados'].length; i++){
      produto += "<a href='visualizar.php?id=" + 
      resposta['dados'][i]['id'] + "'>" + resposta['dados'][i]['nome'] + "</a><br><br>";
    }
  }else{
    produto += "<div class='alert alert-danger' role='alert'>" + resposta['msg'] + "</div>";
  }
  document.getElementById('listar_produtos').innerHTML = produto;
}

const pesqProdutoForm = document.getElementById('pesq-produto-form');
pesqProdutoForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const nome = document.getElementById("produto").value;
  listar_produto(nome);
})