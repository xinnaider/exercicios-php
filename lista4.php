<?php

include 'biblioteca.php';

$connection = pg_connect("dbname=db_papelaria host=localhost port=5432 password=admin user=postgres");

function adicionarProduto ($connection){

    function headerProdutos(){
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

    pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk, quantidade_mov) VALUES ('E','$data $hora', $idproduto, $qtdpro);");
    
}

function alterProduto ($connection){
    clear();
    visualizarProdutos ($connection);

    $id = readline("Digite o id do produto: ");
    $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
    $selectProdutos = pg_fetch_all($selectProdutos);

    $selectProdutos = $selectProdutos[0]['quantidade_pro'];

    clear();

    $escolha = strtoupper(readline("Você deseja dar entrada ou retirar algum item? (E/S)"));

    switch($escolha){
        case "E":
            $quantidadenova = readline("Quanto você deseja adicionar?: ");

            pg_query($connection, "UPDATE produto SET quantidade_pro = $quantidadenova + $selectProdutos WHERE (id_pro = $id)");
            
            $idAuto = pg_query($connection, "SELECT * FROM produto WHERE (id_pro ='$id')");
            $idAuto = pg_fetch_all($idAuto);

            $hora = date("h:i:s");
            $data = date("Y/m/d");
        
            $idproduto = $idAuto[0]['id_pro'];
        
            pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk, quantidade_mov) VALUES ('E','$data $hora', $idproduto, $quantidadenova);");

            break;
        case "S":
            $quantidadenova = readline("Quanto você deseja remover?: ");

            if($quantidadenova > $selectProdutos){
                print "Você não pode remover $quantidadenova items, o seu stock para esse item é de $selectProdutos";
                readline();
            }
            else {
            pg_query($connection, "UPDATE produto SET quantidade_pro = $selectProdutos - $quantidadenova WHERE (id_pro = $id)");
            
            $idAuto = pg_query($connection, "SELECT * FROM produto WHERE (id_pro ='$id')");
            $idAuto = pg_fetch_all($idAuto);

            $hora = date("h:i:s");
            $data = date("Y/m/d");
        
            $idproduto = $idAuto[0]['id_pro'];
        
            pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk, quantidade_mov) VALUES ('S','$data $hora', $idproduto, $quantidadenova);");

            }
            break;
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

function visualizarMovimentacoes ($connection){
    $selectProdutos = pg_query($connection, "SELECT id_mov, tipo_mov, nome_pro, data_mov, quantidade_mov FROM movimentacoes, produto WHERE (id_produto_fk = id_pro) ORDER by id_mov ASC;");
    $selectProdutos = pg_fetch_all($selectProdutos);

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    foreach ($selectProdutos as $linha){
        echo "░" . str_pad($linha['id_mov'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['tipo_mov'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['data_mov'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_mov'], 25, " ", STR_PAD_BOTH)."░ \n";
    }
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
}

function imprimirRelatorioMoveGeral ($connection){
    $selectProdutos = pg_query($connection, "SELECT id_mov, tipo_mov, nome_pro, data_mov, quantidade_mov FROM movimentacoes, produto WHERE (id_produto_fk = id_pro) ORDER by id_mov ASC;");
    $selectProdutos = pg_fetch_all($selectProdutos);

    $myfile = fopen("relatorio.csv", "a+") or die("Unable to open file!");
    $texto = "ID; TIPO DA MOVIMENTACAO; NOME DO PRODUTO; DATA DA MOVIMENTACAO; QUANTIDADE MOVIMENTADA";
    fwrite($myfile, $texto . "\n");
    foreach($selectProdutos as $linha){
        $texto = $linha['id_mov'] . ";" . $linha['tipo_mov'] . ";" . $linha['nome_pro'] . ";" . $linha['data_mov'] . ";" . $linha['quantidade_mov'];
        fwrite($myfile, $texto . "\n");
    }
    fclose($myfile);
}

function imprimirRelatorioEspecifico ($connection){
    clear();
    visualizarProdutos ($connection);

    $id = readline("Digite o id do produto: ");
    $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
    $selectProdutos = pg_fetch_all($selectProdutos);

    $myfile = fopen("relatorio.csv", "a+") or die("Unable to open file!");
    
    $texto = "ID; NOME DO PRODUTO; MARCA DO PRODUTO; PRECO DO PRODUTO; QUANTIDADE DO PRODUTO";
    fwrite($myfile, $texto . "\n");
    foreach($selectProdutos as $linha){
        $texto = $linha['id_pro'] . ";" . $linha['nome_pro'] . ";" . $linha['marca_pro'] . ";" . $linha['preco_pro'] . ";" . $linha['quantidade_pro'];
        fwrite($myfile, $texto . "\n");
    }
    fclose($myfile);
    clear();

}

imprimirRelatorioEspecifico($connection);
