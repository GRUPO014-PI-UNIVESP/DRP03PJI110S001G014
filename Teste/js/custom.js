async function carregar_produtos(valor){
  if(valor.length >= 1){
    const dados = await fetch('pesquisar_produtos.php?nome=' + valor);
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

function listar_produto(nome){
  console.log(nome);
}

//minuto 44:30