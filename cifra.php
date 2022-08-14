<?php

#José Fernando Gomes Marcial e Antônio Palauro Sampaio

$palavra = null;

function verificarChave(){
    $a = false;
    while($a == false){
        clear();
        $chave = readline('Digite a chave da criptografia (0 a 26): ');
        if($chave > 26){
        }
        else {$a = true; return $chave;}
    }

}

function clear () {
    popen('cls', 'w');
}

function danilomal ($palavra, $chave) {
    $cryp = "";
    for ($i=0; $i < strlen($palavra); $i++) { 
        $cryp .= chr(ord($palavra[$i]) - $chave);
    }

    return $cryp;
}

function danilobom ($palavra, $chave) {
    $dcryp = "";
    for ($i=0; $i < strlen($palavra); $i++) { 
        $dcryp .= chr(ord($palavra[$i]) + $chave);
    }

    return $dcryp;
}

function menu ($palavra, $chave){


    clear();

    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n";
    print "░ 「 1 」 Criptografar              ░\n";
    print "░ 「 2 」 Descriptografar           ░\n";
    print "░ 「 3 」 Sair                      ░\n";
    print "▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬\n \n";

    $escolha = readline('Digite o número referente a opção desejada: ');

    clear();

    switch($escolha){
        case 1:
            $palavra = readline('Digite a palavra que você deseja criptografar: ');
            $chave = verificarChave();
            clear();
            print "Palavra sem criptografia: $palavra \n";
            print "Palavra criptografada: " . danilomal($palavra, $chave) . "\n";
            print "Chave de criptografia: $chave \n \n";
            print "Pressione qualquer botão para continuar";
            readline();
            menu($palavra, $chave);
            break;
        case 2:
            $palavra = readline('Digite a palavra que você deseja descriptografar: ');
            $chave = verificarChave();
            clear();
            print "Palavra descriptografada: " . danilobom($palavra, $chave) . "\n";
            print "Palavra criptografada: $palavra \n";
            print "Chave de descriptografia: $chave \n \n";
            print "Pressione qualquer botão para continuar";
            readline();
            menu($palavra, $chave);
            break;
        case 3:
            exit();
        default:
            menu($palavra, $chave);
            break;
    }
}

menu($palavra, $chave);