<?php
  // P04.BuscaCEp.php
  // Modulo que faz busca de endereço a partir do CEP postal

    include('P01ConectDB.php');

    //verifica se sessão está ativa e reativa
    if(!isset($_SESSION)){
          session_start();
    }
    function get_endereco($cep){

    // formatar o cep removendo caracteres nao numericos
    $cep = preg_replace("/[^0-9]/", "", $cep);
    $url = "http://viacep.com.br/ws/$cep/xml/";

    $xml = simplexml_load_file($url);
    return $xml;
    }
    if($_POST['cep']){
      $endereco = get_endereco($_POST['cep']);
      $_SESSION['CepCapturado']     =  $endereco->cep;
      $_SESSION['RuaCapturado']     =  $endereco->logradouro;
      $_SESSION['BairroCapturado']  =  $endereco->bairro;
      $_SESSION['CidadeCapturado']  =  $endereco->localidade;
      $_SESSION['UFCapturado']      =  $endereco->uf;
    }
?>