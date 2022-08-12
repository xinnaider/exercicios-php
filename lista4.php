<?php

include 'biblioteca.php';

$connection = pg_connect("dbname=db_papelaria host=localhost port=5432 password=admin user=postgres");

function adicionarProduto ($connection){

    function headerProdutos (){
        clear();
        print "==================";
        print " INSERIR PRODUTOS ";
        print "================== \n \n";
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

    $idproduto = $idAuto[0]['id_pro'];

    pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk) VALUES ('E','$data $hora', $idproduto);");
    
}

function alterProduto ($connection){
    clear();
    visualizarProdutos ($connection);

    $id = readline("Digite o id do produto: ");
    $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
    $selectProdutos = pg_fetch_all($selectProdutos);

    $selectProdutos = $selectProdutos[0]['quantidade_pro'];

    clear();

    $escolha = readline("Você deseja dar entrada ou retirar algum item? (E/R)");

    switch($escolha){
        case "E":
            $quantidadenova = readline("Quanto você deseja adicionar?: ");

            pg_query($connection, "UPDATE produto SET quantidade_pro = $quantidadenova + $selectProdutos WHERE (id_pro = $id)");

            $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");

            print_r($selectProdutos);
        CASE "R":
            $quantidadenova = readline("Quanto você deseja remover?: ");

            if($quantidadenova > $selectProdutos){
                print "Você não pode remover $quantidadenova items, o seu stock para esse item é de $selectProdutos";

                readline();
            }
            else {
            pg_query($connection, "UPDATE produto SET quantidade_pro = $selectProdutos - $quantidadenova WHERE (id_pro = $id)");

            $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
            $selectProdutos = pg_fetch_all($selectProdutos);
            }
    }

}

function visualizarProdutos ($connection){
    $selectProdutos = pg_query($connection, "SELECT * FROM produto ORDER by id_pro ASC");
    $selectProdutos = pg_fetch_all($selectProdutos);

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    foreach ($selectProdutos as $linha){
        echo "░" . str_pad($linha['id_pro'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['marca_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['preco_pro'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_pro'], 25, " ", STR_PAD_BOTH)."░ \n";
    }
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
}

alterProduto ($connection);

