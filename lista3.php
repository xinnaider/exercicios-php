<?php 

$arrayex1 = [1, 5, 7, 8, 1, 20];
$arrayex2 = [1, 5, 7, 1];

#Escreva uma função que receba um array de valores numéricos e retorne o valor mais alto.

function maiorValor($array){
    $numStorage = 0;
    foreach ($array as $array){
        if($numStorage < $array){
            $numStorage = $array;
        }
    }

    return $numStorage;
}

#Escreva uma função que receba um array de valores numéricos e retorne a soma dos valores.

function somarValores($array){
    $numStorage = 0;
    foreach ($array as $array){
        $numStorage = $numStorage + $array;
    }

    return $numStorage;
}

#Escreva uma função que receba dois arrays e retorne um array de valores intercalados.

function retornarIntercalados($array, $iarray){
    foreach ($array as $key => $value){
        if(empty($value) == false){
            $numStorage[] = $value;
        }
        if(empty($iarray[$key]) == false){
            $numStorage[] = $iarray[$key];
        }
    }
    
    return $numStorage;
}

#Escreva uma função como a anterior, mas que retorne um array de pares.

function retornarPares($array, $iarray){
    foreach ($array as $key => $value){
        if(empty($value) == true){
            $numStorage[] = [$iarray[$key]];
        }
        if(empty($iarray[$key]) == true){
            $numStorage[] = [$value];
        }
        else {
            $numStorage[] = [$value, $iarray[$key]];
        }
    }
    
    return $numStorage;
}

#Escreva uma função que receba um array associativo e um array de strings, e retorne uma versão do primeiro array somente com as chaves do segundo.

$arrayex6e1 = ['nome' => 'Jacó', 'idade' => 74, 'profissão' => 'ancião'];
$arrayex6e2 = ['nome', 'profissão'];

function retornarPrimeiro($array, $arraychaves){
    $contar = 0;

    foreach ($arraychaves as $conteudo){
        $contar++;
    }

    for ($i = 0; $i < $contar; $i++) { 
        print $arraychaves[$i] . ": ". $array[$arraychaves[$i]] . "\n \n";
    }
}

// retornarPrimeiro($arrayex6e1, $arrayex6e2);

#Escreva uma função que reverta um array.

function reverterArray($array){
    $count = -1;
    foreach ($array as $valor){
        $count++;
    }

    $armazenar = $count;

    for ($i=-1; $i < $count; $i++) { 
        $ar2[] = $array[$armazenar];
        $armazenar--;
    }

    return $ar2;
}

// print_r(reverterArray($arrayex1));

#Desafio: escreva uma função que achate um array multidimensional.

$arraymulti = [1, [1, 2], [1, [2, 3], 4]];

function achatarArray($arraymulti){

    for ($i=0; $i < count($arraymulti); $i++) { 
        print $arraymulti[$i] . "\n \n";
    }
}

// achatarArray($arraymulti);

#Escreva uma função que remova valores duplicados de um array.

$arraydupli = [1, 2, 3, 3, 4, 5, 4];

function removerDuplicados($array){
    foreach ($array as $conteudo) {
        $numStorage[$conteudo] = $conteudo;
    }

    return $numStorage;
}

// print_r(removerDuplicados($arraydupli));

# Escreva uma função que ordene um array.

$arrayord = [2, 5, 6, 2, 4, 8];

function ordenarArray($array, $trueorfalse){
    

    $count = 0;

    foreach ($array as $valor){
        $count++;
    }

    for ($i=0; $i < $count; $i++) { 
        $maior = null;
        foreach ($array as $key => $conteudo) {
            if ($maior < $conteudo){
                $maior = $conteudo;
                $chave = $key;
            }
        }
        $numStorage[] = $maior;
        unset($array[$chave]);
    }

    if($trueorfalse == true){
        return reverterArray($numStorage);
    }   return $numStorage;
}

// print_r(ordenarArray($arrayord, true));