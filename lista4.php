<?php

include 'biblioteca.php';

$connection = pg_connect("dbname=db_papelaria host=localhost port=5432 password=admin user=postgres");

menu ($connection);

function menu ($connection){
    
    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░             Papelaria             ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ 「 1 」 Cadastrar novos produtos  ░\n";
    print "░ 「 2 」 Verificar estoque         ░\n";
    print "░ 「 3 」 Verificar movimentações   ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $escolha = readline("Insira o número referente à opção desejada: ");

    switch($escolha){
        case 1:
            adicionarProduto($connection);
            break;
        case 2:
            visualizarProdutos ($connection);
            break;
        case 3:
            visualizarMovimentacoes($connection);
            break;
        default:
            menu($connection);
            break;
    }
}

function adicionarProduto ($connection){

    function headerProdutos(){
        clear();
        print "==================";
        print " Cadastrar novo PRODUTO ";
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

    clear();

    $escolha = 0;

    while ($escolha == 0) {

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░ Insira o número referente a opção desejada     ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░ 「 1 」 Continuar cadastrando novos produtos   ░\n";
        print "░ 「 2 」 Retornar ao menu                       ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

        $escolha2 = readline("Digite a opção desejada: ");
        
        if($escolha2 == 1){
            $escolha = 1;
            adicionarProduto ($connection);
        }
        else if($escolha2 == 2){
            $escolha = 1;
            menu($connection);
        }
    }
}

function alterProduto ($connection, $escolha){
    clear();

    $id = $escolha;
    $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
    $selectProdutos = pg_fetch_all($selectProdutos);

    $selectProdutos = $selectProdutos[0]['quantidade_pro'];

    clear();

    $escolha = strtoupper(readline("Você deseja dar ENTRADA ou SAIDA no item especificado? (E/S)"));

    switch($escolha){
        case "E":
            clear();

            print "▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
            print "░  ENTRADA  ░\n";
            print "▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
            $quantidadenova = readline("Quanto você deseja adicionar? ");

            pg_query($connection, "UPDATE produto SET quantidade_pro = $quantidadenova + $selectProdutos WHERE (id_pro = $id)");
            
            $idAuto = pg_query($connection, "SELECT * FROM produto WHERE (id_pro ='$id')");
            $idAuto = pg_fetch_all($idAuto);

            $hora = date("h:i:s");
            $data = date("Y/m/d");
        
            $idproduto = $idAuto[0]['id_pro'];
        
            pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk, quantidade_mov) VALUES ('E','$data $hora', $idproduto, $quantidadenova);");
            visualizarProdutos ($connection);
            break;

        case "S":
            clear();
            print "▬▬▬▬▬▬▬▬▬▬▬\n";
            print "░  SAIDA  ░\n";
            print "▬▬▬▬▬▬▬▬▬▬▬\n \n";
            $quantidadenova = readline("Quanto você deseja remover? ");

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

            // $dataFormatada = date('d/m/Y', strtotime('-1 '));
        
            $idproduto = $idAuto[0]['id_pro'];
        
            pg_query($connection, "INSERT INTO movimentacoes(tipo_mov, data_mov, id_produto_fk, quantidade_mov) VALUES ('S','$data $hora', $idproduto, $quantidadenova);");

            }
            visualizarProdutos ($connection);
            break;
    }

}

function visualizarProdutos ($connection){
    clear();
    $selectProdutos = pg_query($connection, "SELECT * FROM produto ORDER by id_pro ASC");
    $selectProdutos = pg_fetch_all($selectProdutos);

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    foreach ($selectProdutos as $linha){
        echo "░" . str_pad($linha['id_pro'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['marca_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['preco_pro'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_pro'], 25, " ", STR_PAD_BOTH)."░ \n";
    }
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
    
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ • Digite o número referente ao produto para acessa-lo ░\n";
    print "░ • Digite a letra G para imprimir o relatório geral    ░\n";
    print "░ • Digite a letra R para retornar ao menu              ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

    $escolha = trim(strtolower(readline("----> ")));

    $choice = isset($escolha);
    if($escolha == "g"){
        imprimirProdutosGeral($connection);
        visualizarProdutos ($connection);
    }
    else if($escolha == "r"){
        menu($connection);
    }
    else if ($choice === false || $escolha === ""){
        clear();

        print "Você não digitou nada! \n \n";
        readline("Pressione qualquer botão para continuar");
        visualizarProdutos($connection);
    }
    else if($escolha > count($selectProdutos) || $escolha == 0)
    {
        clear();
        print "Digite uma opção válida\n \n";
        readline("Pressione qualquer botão para continuar");
        visualizarProdutos($connection);
    }
    clear();

    $laco = 0;

    while ($laco == 0){
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░ • Digite 1 para dar entrada ou saida no produto        ░\n";
        print "░ • Digite 2 para visualizar o relatório especifico      ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

        $escolhaswitch = readline("----> ");

        switch($escolhaswitch){
            case 1:
                alterProduto($connection, $escolha);
                $laco = 1;
                break;
            case 2:
                imprimirRelatorioEspecifico ($connection, $escolha, false);
                $laco = 1;
                break;
            default:
        }
    }


}

function visualizarMovimentacoes ($connection){
    clear();
    $selectProdutos = pg_query($connection, "SELECT id_mov, tipo_mov, nome_pro, data_mov, quantidade_mov FROM movimentacoes, produto WHERE (id_produto_fk = id_pro) ORDER by id_mov ASC;");
    $selectProdutos = pg_fetch_all($selectProdutos);

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    foreach ($selectProdutos as $linha){
        echo "░" . str_pad($linha['id_mov'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['tipo_mov'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['data_mov'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_mov'], 25, " ", STR_PAD_BOTH)."░ \n";
    }
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ • Digite M para salvar o relatório de movimentação     ░\n";
    print "░ • Digite R para retornar ao menu                       ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

    $escolha = trim(strtolower(readline("----> ")));

    if($escolha == "r"){
        menu($connection);
    }
    else if ($escolha == "m"){
        imprimirRelatorioMoveGeral($connection);
    }
    else if ($escolha === ""){
        clear();
        print "Você não digitou nada! \n \n";
        readline("Pressione qualquer botão para continuar");
        visualizarProdutos($connection);
    }
    else {
        visualizarMovimentacoes($connection);
    }


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

function imprimirRelatorioEspecifico ($connection, $escolha, $trueorfalse){
    
    if ($trueorfalse == true){
        $id = $escolha;
        $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $id)");
        $selectProdutos = pg_fetch_all($selectProdutos);

        clear();

        while (True){
            $nomecsv = readline("Qual será o nome do arquivo? ");
            if(file_exists($nomecsv . ".csv")){
                clear();
                readline("Esse arquivo já existe, tente outro nome");
            } else {
                $myfile = fopen($nomecsv . ".csv", "a+") or die("Unable to open file!");
            
                $texto = "ID; NOME DO PRODUTO; MARCA DO PRODUTO; PRECO DO PRODUTO; QUANTIDADE DO PRODUTO";
                fwrite($myfile, $texto . "\n");
                foreach($selectProdutos as $linha){
                    $texto = $linha['id_pro'] . ";" . $linha['nome_pro'] . ";" . $linha['marca_pro'] . ";" . $linha['preco_pro'] . ";" . $linha['quantidade_pro'];
                    fwrite($myfile, $texto . "\n");
                }
                fclose($myfile);
        
                $selectProdutos = pg_query($connection, "SELECT id_mov, tipo_mov, nome_pro, data_mov, quantidade_mov FROM movimentacoes, produto WHERE (id_produto_fk = $id) and (id_produto_fk = id_pro) ORDER by id_mov ASC;");
                $selectProdutos = pg_fetch_all($selectProdutos);
                
                $myfile = fopen($nomecsv . ".csv", "a+") or die("Unable to open file!");
                $texto = "ID; TIPO DA MOVIMENTACAO; NOME DO PRODUTO; DATA DA MOVIMENTACAO; QUANTIDADE MOVIMENTADA";
                fwrite($myfile, $texto . "\n");
                foreach($selectProdutos as $linha) {
                    $texto = $linha['id_mov'] . ";" . $linha['tipo_mov'] . ";" . $linha['nome_pro'] . ";" . $linha['data_mov'] . ";" . $linha['quantidade_mov'];
                    fwrite($myfile, $texto . "\n");
                }
                fclose($myfile);
                clear();
                break;
            }
        }
    } else {
        clear();
        $selectProdutos = pg_query($connection, "SELECT * FROM produto WHERE (id_pro = $escolha)");
        $selectProdutos = pg_fetch_all($selectProdutos);

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
            foreach ($selectProdutos as $linha){
                echo "░" . str_pad($linha['id_pro'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['marca_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['preco_pro'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_pro'], 25, " ", STR_PAD_BOTH)."░ \n";
            }
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

        $selectProdutos = pg_query($connection, "SELECT id_mov, tipo_mov, nome_pro, data_mov, quantidade_mov FROM movimentacoes, produto WHERE (id_produto_fk = $escolha) and (id_produto_fk = id_pro) ORDER by id_mov ASC;");
        $selectProdutos = pg_fetch_all($selectProdutos);

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        foreach ($selectProdutos as $linha){
            echo "░" . str_pad($linha['id_mov'], 7, " ", STR_PAD_BOTH) ."░". str_pad($linha['tipo_mov'], 25, " ", STR_PAD_BOTH) ."░". str_pad($linha['nome_pro'], 25, " ", STR_PAD_BOTH) . "░". str_pad($linha['data_mov'], 25, " ", STR_PAD_BOTH) . "░" . str_pad($linha['quantidade_mov'], 25, " ", STR_PAD_BOTH)."░ \n";
        }
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░ • Digite M para salvar o relatório especifico          ░\n";
        print "░ • Digite R para retornar ao menu                       ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

        $escolha2 = trim(strtolower(readline("----> ")));

        if($escolha2 == "r"){
            menu($connection);
        }
        else if ($escolha2 == "m"){
            imprimirRelatorioEspecifico($connection, $escolha, true);
        }
        else if ($escolha2 === ""){
            clear();
            print "Você não digitou nada! \n \n";
            readline("Pressione qualquer botão para continuar");
            visualizarProdutos($connection);
        }
        else {
            imprimirRelatorioEspecifico ($connection, $escolha, false);
        }

    }

}

function imprimirProdutosGeral ($connection){
    $selectProdutos = pg_query($connection, "SELECT * FROM produto ORDER by id_pro ASC");
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