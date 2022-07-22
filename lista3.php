<?php 

#ex1

$arrayex1 = [1, 5, 7, 8, 1, 20];
$arrayex2 = [1, 5, 7, 1];

function maiorValor($array){
    $numStorage = 0;
    foreach ($array as $array){
        if($numStorage < $array){
            $numStorage = $array;
        }
    }

    return $numStorage;
}

#ex2

function somarValores($array){
    $numStorage = 0;
    foreach ($array as $array){
        $numStorage = $numStorage + $array;
    }

    return $numStorage;
}

#ex3

function retornarIntercalados($array, $iarray){
    foreach ($array as $key => $value){
        $numStorage[] = [$value, $iarray[$key]];
    }
    
    return $numStorage;
}

#ex4

function retornarIntercalados2($array, $iarray){
    foreach ($array as $key => $value){
        $numStorage[] = [$value, $iarray[$key]];
    }
    
    return $numStorage;
}
