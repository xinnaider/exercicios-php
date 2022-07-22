<?php

include 'biblioteca.php';

const INICIAR = 1;
const RANKING = 2;
const SAIR = 3;

clear();

menu();

function menu() {

    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ Bem-vindo ao jogo da adivinhação  ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ 「 1 」 Iniciar jogo              ░\n";
    print "░ 「 2 」 Ranking                   ░\n";
    print "░ 「 3 」 Sair :(                   ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $escolha = readline("Insira o número referente à opção desejada: ");

    switch ($escolha) {
        case INICIAR:
            iniciarjogo();
        case RANKING:
            ranking();
            print "\n \n";
            print "Aperte enter para continuar";
            readline();
            menu();
        case SAIR:
            clear();
            exit();
        default:
            menu();
    }

}

function jogocompleto ($nome) {
    $i2 = 0;
    $numerojogo = random_int(0, 100);

    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░                            Regras                            ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ ➪  Adivinhe o número entre 0 a 100 que o computador sorteou  ░\n";
    print "░ ➪  Você tem até 10 chances para acertar o número             ░\n";
    print "░ ➪  Usar menos tentativas cede mais pontos                    ░\n";
    print "░ ➪  Concluir em menos tempo cede mais pontos                  ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
    
    print "Aperte enter para iniciar o jogo, se prepare antes!";
    readline();

    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░   O JOGO COMEÇOU, BOA SORTE!!!   ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";

    $tinicial = microtime(true);
    $fator = true;
    $i = 0;

    while ($fator == true) {
        $tentativa = readline("Digite um número: ");

        if (is_numeric($tentativa)) {
            $i = $i + 10;
            $i2++;
            if($tentativa == $numerojogo){

                $tfinal = microtime(true);
                $tresultado = $tfinal - $tinicial;
                $tresultado = number_format($tresultado, 2, '.', ',');
    
                $pontos = 110 - $i;
                $pontos2 = $pontos / $tresultado;
                $pontos2 = number_format($pontos2, 2, '.', ',');
    
                clear();

                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                print "░                VOCÊ GANHOU!!!             ░\n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                echo "░" . str_pad("  -> Parabéns, você acertou o número!", 46, " ") . "░ \n";
                echo "░" . str_pad("  -> Você fez: " . $pontos2 . " pontos", 44, " ") . "░ \n";
                echo "░" . str_pad("  -> Você terminou em " . $tresultado . "s", 44, " ") . "░ \n";
                echo "░" . str_pad("  -> Nome do usuário: " . $nome, 44, " ") . "░ \n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
    
                $newArray = lerRegistro();

                foreach ($newArray as $newArray){
                    if($newArray['Pontos'] < $pontos2){
                        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ \n";
                        print "░ Parabéns, você bateu a maior pontuação da máquina ░ \n";
                        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ \n \n";
                    }
                    else{
                        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                        print "░ Você não atingiu a maior pontuação da máquina :(  ░\n";
                        print "░". str_pad(" A maior pontuação da máquina é: " . $newArray['Pontos'], 55, " ", STR_PAD_RIGHT) . "░\n";
                        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
                        
                    }
                    break;

                }
    
                vList ($nome, $pontos2, $tresultado, $i2);
    
                $fator = false;
    
                print "Aperte enter para continuar";
                readline();
    
                $escolha = 0;
    
                while ($escolha == 0) {
    
                    clear();
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                    print "░ Insira o número referente a opção desejada     ░\n";
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                    print "░" . str_pad(" 「 1 」 Continuar jogando como: " . $nome . "", 50, " ") . "░\n";
                    print "░ 「 2 」 Retornar ao menu                       ░\n";
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

                    $escolha2 = readline("Digite a opção desejada: ");
    
                    if($escolha2 == 1){
                        $escolha = 1;
                        jogocompleto($nome);
                    }
                    else if($escolha2 == 2){
                        $escolha = 1;
                        menu();
                    }
                }
            }
    
            if ($i >= 100) {
                clear();
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                print "░ A quantidade de tentativas acabou :(       ░\n";
                print "░" . str_pad(" O número a ser adivinhado era: " . $numerojogo  . "", 45, " ") . "░\n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

                $fator = false;
    
                print "Aperte enter para continuar";
                readline();
    
                $escolha = 0;
    
                while ($escolha == 0) {
    
                    clear();
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                    print "░ Insira o número referente a opção desejada     ░\n";
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                    print "░" . str_pad(" 「 1 」 Tentar novamente como: " . $nome . "", 50, " ") . "░\n";
                    print "░ 「 2 」 Retornar ao menu                       ░\n";
                    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
    
                    $escolha2 = readline("Digite a opção desejada: ");
    
                    if($escolha2 == 1){
                        $escolha = 1;
                        jogocompleto($nome);
                    }
                    else if($escolha2 == 2){
                        $escolha = 1;
                        menu();
                    }
                }
                
            }
        
            if($tentativa > $numerojogo){
                clear();
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                print "░".str_pad(" ". $i2. "º Tentativa ", 44, " ") . "░\n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";

                print "─────────────────────────────────────────────\n";
                print "░".str_pad(" CHUTOU ALTO! ↑ [" . $tentativa . "] ", 44, " ") . "░\n";
                print "─────────────────────────────────────────────\n \n";
            }
            else {
                clear();
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                print "░".str_pad(" ". $i2. "º Tentativa ", 44, " ") . "░\n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";
    
                print "─────────────────────────────────────────────\n";
                print "░".str_pad(" CHUTOU BAIXO! ↓ [" . $tentativa . "] ", 44, " ") . "░\n";
                print "─────────────────────────────────────────────\n \n";
            }
        }
        else {
            clear();
            print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
            print "░".str_pad(" ". $i2. "º Tentativa ", 44, " ") . "░\n";
            print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";

            print "─────────────────────────────────────────────\n";
            print "░ Você precisa digitar um número!           ░\n";
            print "─────────────────────────────────────────────\n \n";
        }
        
    }

}

function rRegistrar ($nome, $tresultado, $pontos2, $i2) {
    $listaranking = [$nome, $tresultado, $pontos2, $i2];

    $fp = fopen('ranking.txt', 'a+');
    fputcsv($fp, $listaranking);

    fclose($fp);
}

function lerRegistro () {
    $registro = [];
    if (($fp = fopen('ranking.txt', 'r')) !== FALSE){
        while (($data = fgetcsv($fp, 1000, ',')) !== FALSE){ 
            $registro[] = ['Nome' => $data[0], 'Tempo' => $data[1], 'Pontos' => $data[2], 'Tentativas' => $data[3]];
        }
        fclose($fp);

        $newArray = arraySort($registro, 'Pontos');
        return $newArray;
    }
}

function ranking () {
    $newArray = lerRegistro();
    clear();

    $i2 = 1;
    
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    echo "░" . str_pad("Posição", 26, " ", STR_PAD_BOTH) ."░". str_pad("Nome", 25, " ", STR_PAD_BOTH) ."░". str_pad("Tempo (s)", 25, " ", STR_PAD_BOTH)."░". str_pad("Pontos", 25, " ", STR_PAD_BOTH) ."░". str_pad("Tentativas", 25, " ", STR_PAD_BOTH) . "░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    foreach ($newArray as $newArray){
        echo "░" . str_pad($i2++ . "º", 25, " ", STR_PAD_BOTH) ."░". str_pad($newArray['Nome'], 25, " ", STR_PAD_BOTH) ."░". str_pad($newArray['Tempo'], 25, " ", STR_PAD_BOTH) ."░". str_pad($newArray['Pontos'], 25, " ", STR_PAD_BOTH) . "░". str_pad($newArray['Tentativas'], 25, " ", STR_PAD_BOTH) ."░ \n"; 
        print "----------------------------------------------------------------------------------------------------------------------------------\n"; 
        if($i2 == 11) 
        break;
    }
}

function vList ($nome, $pontos2, $tresultado, $i2){
    $newArray = lerRegistro();
    $verificar = 0;

    foreach ($newArray as $newArray2)
    {
        if($newArray2['Nome'] == $nome){
            $verificar = 1;
            break;
        }
    }

    if($verificar == 1){
        foreach ($newArray as $newArray){
            if($newArray['Nome'] == $nome && $newArray['Pontos'] < $pontos2){
                $linha = $newArray['Tempo']; // conteudo da linha a ser retirada
                $substituirpor = $tresultado;
                $arquivo = "ranking.txt";
                $conteudo = file_get_contents($arquivo);
                $novoconteudo = str_replace($linha, $substituirpor, $conteudo);
                $gravar = fopen($arquivo, "w");
                fwrite($gravar, $novoconteudo);
                fclose($gravar);

                $linha = $newArray['Tentativas']; // conteudo da linha a ser retirada
                $substituirpor = $i2;
                $arquivo = "ranking.txt";
                $conteudo = file_get_contents($arquivo);
                $novoconteudo = str_replace($linha, $substituirpor, $conteudo);
                $gravar = fopen($arquivo, "w");
                fwrite($gravar, $novoconteudo);
                fclose($gravar);

                $linha = $newArray['Pontos']; // conteudo da linha a ser retirada
                $substituirpor = $pontos2;
                $arquivo = "ranking.txt";
                $conteudo = file_get_contents($arquivo);
                $novoconteudo = str_replace($linha, $substituirpor, $conteudo);
                $gravar = fopen($arquivo, "w");
                fwrite($gravar, $novoconteudo);
                fclose($gravar);
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
                print "░ Você atingiu a sua maior pontuação ░\n";
                print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";
                break;
            }
        }
    }
    else{
        rRegistrar ($nome, $tresultado, $pontos2, $i2);
    }
}

function perguntarNome () {
    clear();
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ Digite o seu nome para registrarmos no ranking  ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";
    $nome = readline("Nome: ");

    $comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å',
                        'ç',
                        'è', 'é', 'ê', 'ë', 
                        'ì', 'í', 'î', 'ï', 
                        'ñ', 
                        'ò', 'ó', 'ô', 'õ', 'ö', 
                        'ù', 'ü', 'ú', 
                        'ÿ', 
                        'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 
                        'Ç', 'È', 'É', 'Ê', 'Ë', 
                        'Ì', 'Í', 'Î', 'Ï', 
                        'Ñ', 
                        'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 
                        'Ù', 'Ü', 'Ú');

    $semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 
                        'c', 
                        'e', 'e', 'e', 'e',
                        'i', 'i', 'i', 'i',
                        'n',
                        'o', 'o', 'o', 'o', 'o',
                        'u', 'u', 'u',
                        'y', 
                        'A', 
                        'A', 'A', 'A', 'A', 'A', 
                        'C', 'E', 'E', 'E', 'E', 
                        'I', 'I', 'I', 'I', 'N', 
                        'O', 'O', 'O', 'O', 'O', 'O', 
                        'U', 'U', 'U');

    $nome = str_replace($comAcentos, $semAcentos, $nome);
    $nome = strtolower($nome);

    return $nome;  
}

function verificarNome ($nome) {
    $nomecount = strlen($nome);

    if($nomecount > 10){
        clear();
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░ O nome não pode ter mais de 10 caracteres ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";
        print "Aperte enter para continuar";
        readline();

        return false;

    }
    $nomevazio = trim($nome);
    if(empty($nomevazio)){
        clear();
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
        print "░   O nome não pode conter apenas espaço    ░\n";
        print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n\n";
        print "Aperte enter para continuar";
        readline();

        return false;

    }
    else{
        return true;
    }
}

function iniciarjogo () {
    $nome = perguntarNome();
    $verificar = verificarNome($nome);
    if($verificar == false){
        iniciarjogo();
    }
    else{
        jogocompleto($nome);
    }
}