<?php

$arrayex1 = [1, 2, 3, 4, 4, 3, 3, 3];
$arrayex2 = [1, 5, 7, 1, 1, 3, 4];

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
    $cont1 = contar($array);
    $cont2 = contar($iarray);

    if($cont1 > $cont2){
        $contar = $cont1;
    } else $contar = $cont2;

    for ($i=0; $i < $contar; $i++) { 
        if(!empty($array[$i])){
            $numStorage[] = $array[$i];
        }
        if(!empty($iarray[$i])){
            $numStorage[] = $iarray[$i];
        }
    }
    return $numStorage;
}

#Escreva uma função como a anterior, mas que retorne um array de pares.

function retornarPares($array, $iarray){

    $cont1 = contar($array);
    $cont2 = contar($iarray);

    if($cont1 > $cont2){
        $contar = $cont1;
    } else $contar = $cont2;

    for ($i=0; $i < $contar; $i++) { 
        if(empty($array[$i]) == true){
            $numStorage[] = [$iarray[$i]];
        }
        else if(empty($iarray[$i]) == true){
            $numStorage[] = [$array[$i]];
        }
        else {
            $numStorage[] = [$array[$i], $iarray[$i]];
        }
    }
    
    return $numStorage;
}

print_r(retornarPares($arrayex1, $arrayex2));

#Escreva uma função que receba um array associativo e um array de strings, e retorne uma versão do primeiro array somente com as chaves do segundo.

$arrayex6e1 = ['nome' => 'Jacó', 'idade' => 74, 'profissão' => 'ancião'];
$arrayex6e2 = ['nome', 'profissão'];

function retornarPrimeiro($array, $arraychaves){

    $arrayNovo = [];

    foreach($arraychaves as $linhas){
        $arrayNovo[$linhas] = $array[$linhas];
    }

    return $arrayNovo;
}

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
        $array[$chave] = "";
    }

    if($trueorfalse == true){
        return reverterArray($numStorage);
    }   return $numStorage;
}

// print_r(ordenarArray($arrayord, true));

# Escreva uma função que embaralhe um array.

function contar($array){
    $i = 0;
    foreach ($array as $array){
        $i++;
    }
    
    return $i;
}

function embaralharArray($array){

    $contar = count($array) - 1;

    $arrayX = [];
    $arrayZ = [];
    
    $i = 0;

    $al1 = rand(0,1);
    $al2 = rand(0,1);

    foreach ($array as $linha){
        if($i < $contar/2){
            $arrayX[] = $linha;
        }
        else $arrayZ[] = $linha;
        $i++;
    }
    if ($al1 == 1){
        $arrayX = reverterArray($arrayX);
    }
    if ($al2 == 1){
        $arrayZ = reverterArray($arrayZ);
    }

    $cont1 = contar($arrayX);
    $cont2 = contar($arrayZ); 

    if($cont1 > $cont2){
        $contar = $cont1;
    } else $contar = $cont2;

    for ($i=0; $i < $contar; $i++) { 
        if($i + 1 <= $cont1){
            $numStorage[] = $arrayX[$i];
        }
        if($i + 1 <= $cont2){
            $numStorage[] = $arrayZ[$i];
        }
    }

    return($numStorage);

}

function embaralharArray2 ($array){

    $vezes = rand(3, 10);

    for ($i=0; $i < $vezes; $i++) { 
        $array = embaralharArray($array);
    }

    return $array;
}

#isarray and merge

$abc = [1, 2, 3, 4, [4, 2, [2, 6, 4, [4, 2, 3]], 3, 5], 3, [3,6,7]];

function multiarray ($array){

    $array2 = [];

    foreach($array as $linha){
        if(is_array($linha)){
            $array2 = array_merge($array2, multiarray($linha));
        }
        else {$array2[] = $linha;}
    }

    return $array2;
}
