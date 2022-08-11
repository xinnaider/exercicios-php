<?php

include 'biblioteca.php';

$connection = pg_connect("dbname=db_papelaria host=localhost port=5432 password=admin user=postgres");

function headerProdutos (){
    clear();
    print "==================";
    print " INSERIR PRODUTOS ";
    print "================== \n \n";
}

function selectProduto($connection){

    $jorge = pg_query($connection, "select * from produto");

    $line = pg_fetch_all($jorge);

    print_r($line);
}

headerProdutos();
$nomepro = readline("Nome: ");

headerProdutos();
$marcapro = readline("Marca: ");

headerProdutos();
$precopro = readline("Preço: ");

headerProdutos();
$qtdpro = readline("Quantidade: ");

$hora = date("h:i:s");
$data = date("Y/m/d");

pg_query($connection, "INSERT INTO produto (nome_pro, marca_pro, quantidade_pro, preco_pro) VALUES ('$nomepro', '$marcapro', $qtdpro, $precopro)");

$idAuto = pg_query($connection, "SELECT * FROM produto WHERE (nome_pro ='$nomepro')");
$idAuto = pg_fetch_all($idAuto);

pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk) VALUES ('E','$data $hora', $idAuto[id_pro]);");

selectProduto($connection);





