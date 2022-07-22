<?php

include 'biblioteca.php';

#Biblioteca de temas/palavras

$palavras = (array) json_decode(file_get_contents('palavras.json'), True);

#Jogo e funções

chamarMenu ($palavras);

function chamarMenu ($palavras) {
    
    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░     Bem-vindo ao jogo da forca    ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ 「 1 」 Single player             ░ \n";
    print "░ 「 2 」 Multiplayer               ░\n";
    print "░ 「 3 」 Palavras                  ░\n";
    print "░ 「 4 」 Sair :(                   ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $escolha = readline("Insira o número referente à opção desejada: ");

    switch ($escolha) {
        case 1:
            clear();
            jogarJogo($palavras);
            break;
        case 2:
            clear();
            jogarJogo2($palavras);
            break;
        case 3:
            clear();
            chamarSubMenu($palavras);
            break;
        case 4:
            clear();
            exit('Você saiu do jogo');
        default: 
            clear();
            chamarMenu($palavras);
            break;
    }
}

function chamarSubMenu ($palavras){
    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░         Banca de palavras         ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ 「 1 」 Adicionar novas palavras  ░ \n";
    print "░ 「 2 」 Adicionar novos temas     ░\n";
    print "░ 「 3 」 Retornar ao menu          ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $escolhaSubMenu = readline("Digite a opção desejada: ");

    switch($escolhaSubMenu){
        case 1:
            adicionarPalavra($palavras);
            break;
        case 2:
            adicionarTema($palavras);
            break;
        case 3:
            chamarMenu ($palavras);
            break;
        default:
            chamarSubMenu($palavras);
            break;
    }
    
};

function jogarJogo($palavras) {

    $tema = array_rand($palavras);
    $qtdPalavras = sizeof($palavras[$tema]) - 1;
    $escolhaPalavra = random_int(0,$qtdPalavras);

    #Gerar arrays

    $palavraSemAcentos = preg_split('/(?<!^)(?!$)/u', strtolower(removerAcentos($palavras[$tema][$escolhaPalavra])));
    $palavraComAcentos = preg_split('/(?<!^)(?!$)/u', strtolower($palavras[$tema][$escolhaPalavra]));
    $transformarEmBarras = strtolower(removerAcentos($palavras[$tema][$escolhaPalavra]));
    $palavraNormal = strtolower($palavras[$tema][$escolhaPalavra]);

    $alfabeto = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","ç","1","2","3","4","5","6","7","8","9","@","!","?","$","%");
    $barras = array("_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_");
    $alfabetoBarras = str_replace($alfabeto, $barras, $transformarEmBarras);
    $barrasSeparadas = str_split($alfabetoBarras);

    #Quantidade de letras na palavra

    $contarPalavra = strlen($palavras[$tema][$escolhaPalavra]) - 1;

    $vidas = 6;

    clear();

    $historicoMostra = "";

    while ($vidas > 0){
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n░                                   ░\n";
        gerarDesenho($vidas);
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo str_pad(implode($barrasSeparadas), 35, " ", STR_PAD_BOTH) . "\n                                   \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo  "░" . str_pad("Dica: " . strtoupper($tema), 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "        Letras já utilizadas       \n";
        echo "" . str_pad($historicoMostra, 35, " ", STR_PAD_BOTH) . " \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo "░" . str_pad("Tentativas restantes: $vidas", 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

        $letraTentativa = trim(removerAcentos(strtolower(readline("Insira a letra: "))));
        $contarLetras = strlen($letraTentativa);

        if ($contarLetras > 1){
            clear();

            print "Você digitou uma ou mais letras \n \n";
            continue;
        }
        else if (empty($letraTentativa)){
            clear();

            print "Você não digitou nada! \n \n";
            continue;
        }

        if (strpos($historicoMostra, $letraTentativa) !== false) {
            clear();

            print "Você já inseriu a letra: $letraTentativa \n \n";
            continue;
        }

        $historicoMostra .= "[" . $letraTentativa . "]";

        $retorno = false;
        $percorrer = 0;

        while($percorrer < $contarPalavra){

            $key = array_search($letraTentativa, $palavraSemAcentos);
            if($key === false){
            } else {
                unset($palavraSemAcentos[$key]);
                $barrasSeparadas[$key] = $palavraComAcentos[$key]; 
                $retorno = true;
            }
            $percorrer++;
        }

        clear();

        if($retorno === true){
            clear();
            print "Eu encontrei essa letra! \n \n";
        } else {
            clear();
            print "Eu não encontrei essa letra, você perdeu 1 vida \n \n";
            $vidas--;
        }

        if ($barrasSeparadas === $palavraComAcentos){
            clear();

            print "Parabéns, você concluiu" . "\n \n";

            jogarNovamente1($palavras);
            break;
        }
        if ($vidas == 0) {
            clear();

            gerarDesenho($vidas);

            jogarNovamente1($palavras);
            break;
        }
    }
}

function jogarJogo2($palavras) {

    $tema = array_rand($palavras);
    $qtdPalavras = sizeof($palavras[$tema]) - 1;
    $escolhaPalavra = random_int(0,$qtdPalavras);

    #Gerar arrays

    $palavraSemAcentos = preg_split('/(?<!^)(?!$)/u', strtolower(removerAcentos($palavras[$tema][$escolhaPalavra])));
    $palavraComAcentos = preg_split('/(?<!^)(?!$)/u', strtolower($palavras[$tema][$escolhaPalavra]));
    $transformarEmBarras = strtolower(removerAcentos($palavras[$tema][$escolhaPalavra]));
    $palavraNormal = strtolower($palavras[$tema][$escolhaPalavra]);

    $alfabeto = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","ç","1","2","3","4","5","6","7","8","9","@","!","?","$","%");
    $barras = array("_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_","_");
    $alfabetoBarras = str_replace($alfabeto, $barras, $transformarEmBarras);
    $barrasSeparadas = str_split($alfabetoBarras);

#Quantidade de letras na palavra

$contarPalavra = strlen($palavras[$tema][$escolhaPalavra]) - 1;

    $vidaJg1 = 6;
    $vidaJg2 = 6;
    $interromper = false;
    $historicoMostra = "";

    while ($interromper === false){

        $interromper2 = false;
        $interromper3 = false;

        while ($interromper2 === false) {

        if ($barrasSeparadas === $palavraComAcentos){
            clear();

            print "O jogador 1 ganhou" . "\n \n";
            $interromper = true;
            $interromper2 = true;
            $interromper3 = true;

            jogarNovamente2($palavras);
            break;
            break;
        }
        if ($vidaJg1 == 0) {
            clear();

            gerarDesenho($vidaJg1);

            print "O número de tentativas do jogador 1 acabou \n \n";
            $interromper = true;
            $interromper2 = true;
            $interromper3 = true;

            jogarNovamente2($palavras);
            break;
            break;
        }

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n░                                   ░\n";
        gerarDesenho($vidaJg1);
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo str_pad(implode($barrasSeparadas), 35, " ", STR_PAD_BOTH) . "\n                                   \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo  "░" . str_pad("Dica: " . strtoupper($tema), 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "       Letras já utilizadas        \n";
        echo "" . str_pad($historicoMostra, 35, " ", STR_PAD_BOTH) . " \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░       É a sua vez: JOGADOR 1      ░\n";
        echo "░" . str_pad("Tentativas restantes: $vidaJg1", 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    
        $letraTentativa = trim(removerAcentos(strtolower(readline("Verifique se a palavra tem a letra: "))));
        $contarLetras = strlen($letraTentativa);

        if ($contarLetras > 1){
            clear();

            print "Você digitou uma ou mais letras \n \n";
            continue;
        }
        else if (empty($letraTentativa)){
            clear();

            print "Você não digitou nada! \n \n";
            continue;
        }

        if (strpos($historicoMostra, $letraTentativa) !== false) {
            clear();

            print "Você já inseriu a letra: $letraTentativa \n \n";
            continue;
        }

        $historicoMostra .= "[" . $letraTentativa . "]";

        $retorno = false;
        $percorrer = 0;

        while($percorrer < $contarPalavra){

            $key = array_search($letraTentativa, $palavraSemAcentos);
            if($key === false){
            } else {
                unset($palavraSemAcentos[$key]);
                $barrasSeparadas[$key] = $palavraComAcentos[$key]; 
                $retorno = true;
            }
            $percorrer++;
        }


        if($retorno === true){
            clear();
            print "Eu encontrei essa letra! \n \n";

            continue;
        } else {
            clear();
            print "Eu não encontrei essa letra, o jogador 1 perdeu uma tentativa \n \n";
            $vidaJg1--;
        }

        clear();

        $interromper2 = true;

        }

        while ($interromper3 === false){

        if ($barrasSeparadas === $palavraComAcentos){
            clear();

            print "O jogador 2 ganhou" . "\n \n";

            $interromper = true;
            $interromper2 = true;
            $interromper3 = true;
            jogarNovamente2($palavras);
            break;
            break;
        }
        if ($vidaJg2 == 0) {
            clear();

            gerarDesenho($vidaJg2);

            print "O número de tentativas do jogador 2 acabou";

            $interromper = true;
            $interromper2 = true;
            $interromper3 = true;
            jogarNovamente2($palavras);
            break;
            break;
        }

        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n░                                   ░\n";
        gerarDesenho($vidaJg2); ;
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo "" . str_pad(implode($barrasSeparadas), 35, " ", STR_PAD_BOTH) . "\n                                   \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        echo  "░" . str_pad("Dica: " . strtoupper($tema), 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "       Letras já utilizadas        \n";
        echo "" . str_pad($historicoMostra, 35, " ", STR_PAD_BOTH) . " \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░       É a sua vez: JOGADOR 2      ░\n";
        echo "░" . str_pad("Tentativas restantes: $vidaJg2", 35, " ", STR_PAD_BOTH) . "░ \n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

        $letraTentativa = trim(removerAcentos(strtolower(readline("Verifique se a palavra tem a letra: "))));
        $contarLetras = strlen($letraTentativa);

        if ($contarLetras > 1){
            clear();

            print "Você digitou uma ou mais letras \n \n";
            continue;
        }
        else if (empty($letraTentativa)){
            clear();

            print "Você não digitou nada! \n \n";
            continue;
        }

        if (strpos($historicoMostra, $letraTentativa) !== false) {
            clear();

            print "Você já inseriu a letra: $letraTentativa \n \n";
            continue;
        }

        $historicoMostra .= "[" . $letraTentativa . "]";

        $retorno = false;
        $percorrer = 0;

        while($percorrer < $contarPalavra){

            $key = array_search($letraTentativa, $palavraSemAcentos);
            if($key === false){
            } else {
                unset($palavraSemAcentos[$key]);
                $barrasSeparadas[$key] = $palavraComAcentos[$key]; 
                $retorno = true;
            }
            $percorrer++;
        }

        clear();

        if($retorno === true){
            clear();
            print "Eu encontrei essa letra! \n \n";

            continue;
        } else {
            clear();
            print "Eu não encontrei essa letra, o jogador 2 perdeu uma tentativa \n \n";
            $vidaJg2--;
        }

        $interromper3 = true;

        }

    }

    
}

function adicionarPalavra($palavras) {
    
    clear();

    $contagem = -1;
    $keys = array_keys($palavras);

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░            Lista de grupos            ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

    foreach ($palavras as $chave => $grupo){
        $contagem++;
        echo  "░ $contagem." . str_pad($chave, 35, " ", STR_PAD_BOTH) . "░ \n";
        print "┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈┈\n";
    }
    print "\n \n";

    $escolha = trim(readline("Digite a opção referente ao tema que deseja adicionar novas palavras: "));

    $choice = isset($escolha);
    if ($choice === false || $escolha === ""){
        clear();

        print "Você não digitou nada! \n \n";
        readline("Pressione qualquer botão para continuar");
        adicionarPalavra($palavras);
    }
    if($escolha > $contagem)
    {
        clear();
        print "Digite uma opção válida\n \n";
        readline("Pressione qualquer botão para continuar");
        adicionarPalavra($palavras);
    }

    $temaDaPalavra = $keys[$escolha];

    clear();
    $stop = false;
    while ($stop == false){

    clear();

    $conteudo = strtolower(readline("[P caso deseje parar] Digite a palavra que você deseja adicionar: "));

    if (empty(trim($conteudo))){
        clear();

        print "Você não digitou nada! \n \n";

        readline('Pressione qualquer botão para continuar');
        continue;
    }
    if($conteudo == "p"){
        chamarSubMenu ($palavras);
        $stop = true;
    }

    $found_keys = array_search($conteudo, $palavras[$temaDaPalavra]);
 
    if ($found_keys === false) {
        array_push($palavras[$temaDaPalavra], $conteudo);
        file_put_contents('palavras.json', json_encode($palavras));
    } else {
        print "Essa palavra já existe na banca, tente outra \n \n";
        readline("Pressione qualquer botão para continuar");
    }
    }
}

function adicionarTema($palavras){
    clear();
    
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░            Banca de palavras         ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
    
    $tema = strtolower(readline("Digite o tema que você deseja adicionar: "));

    if (empty(trim($tema))){
        clear();

        print "Você não digitou nada! \n \n";

        readline('Pressione qualquer botão para continuar');
        adicionarTema($palavras);
    }
    if(isset($palavras[$tema])){
        clear();

        echo "Tema: $tema \n \n";
        
        echo "Esse tema já existe no banco de dados \n \n";

        readline("Pressione qualquer botão para voltar");

        adicionarTema($palavras);
    }
    else{
        $stop = false;
        $palavras[$tema] = [];
        while ($stop == false){

            clear();

            $palavra = strtolower(readline("[P caso deseje parar] Digite o palavra que você deseja adicionar no tema $tema: "));

            if($palavra == "p"){
                chamarSubMenu ($palavras);
                $stop = true;
            }
        
            $found_keys = array_search($palavra, $palavras[$tema]);


            if (empty(trim($palavra))){
                clear();

                print "Você não digitou nada! \n \n";

                readline('Pressione qualquer botão para continuar');
                continue;
            }
            if($found_keys === false){
                $palavras[$tema][] = $palavra;
                file_put_contents('palavras.json', json_encode($palavras));
            }
            else {
                print "Essa palavra já existe na banca, tente outra \n \n";
                readline("Pressione qualquer botão para continuar");
            }     
        }
    }
}

function jogarNovamente2($palavras){
    
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░         Você deseja jogar novamente? S/N         ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $miniescolha = strtolower(readline("Insira a opção desejada: "));

    switch($miniescolha){
        case "s":
            clear();
            jogarJogo2($palavras);
            break;
        case "n":
            clear();
            chamarMenu ($palavras);
            break;
        default:
            clear();
            jogarNovamente2($palavras);
            break;
    }
}

function jogarNovamente1($palavras){
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░         Você deseja jogar novamente? S/N         ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $miniescolha = strtolower(readline("Insira a opção desejada: "));

    switch($miniescolha){
        case "s":
            clear();
            jogarJogo($palavras);
            break;
        case "n":
            clear();
            chamarMenu ($palavras);
            break;
        default:
            clear();
            jogarNovamente1($palavras);
            break;
    }
}

function gerarDesenho($desenho){
    switch($desenho){
    case 6:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||     /|\                     ░
░    ||     / \                     ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 5:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||     /|\                     ░
░    ||     /                       ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 4:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||     /|\                     ░
░    ||                             ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 3:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||     /|                      ░
░    ||                             ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 2:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||      |                      ░
░    ||                             ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 1:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||      O                      ░
░    ||                             ░
░    ||                             ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
    case 0:
print "░    ||                             ░                           
░    ||=======                      ░     
░    ||                             ░
░    ||          GAME OVER          ░
░    ||                             ░
░    ||                             ░
░    ||                             ░\n░                                   ░\n";
break; 
}
    
}