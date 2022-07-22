<?php

function clear () {
    popen('cls', 'w');
};

function pularl() {
    echo "\n";
    echo "";
    echo "\n";
}

function arraySort($array, $on, $order=SORT_DESC){
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function removerAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/",
    "/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/",
    "/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/","/(ç)/"),
    explode(" ","a A e E i I o O u U n N c"),$string);
}

mb_internal_encoding("utf-8");

function str_pad_unicode($str, $pad_len, $pad_str = ' ', $dir = STR_PAD_RIGHT) {
    $str_len = mb_strlen($str);
    $pad_str_len = mb_strlen($pad_str);
    if (!$str_len && ($dir == STR_PAD_RIGHT || $dir == STR_PAD_LEFT)) {
        $str_len = 1; // @debug
    }
    if (!$pad_len || !$pad_str_len || $pad_len <= $str_len) {
        return $str;
    }

    $result = null;
    if ($dir == STR_PAD_BOTH) {
        $length = ($pad_len - $str_len) / 2;
        $repeat = ceil($length / $pad_str_len);
        $result = mb_substr(str_repeat($pad_str, $repeat), 0, floor($length))
                . $str
                . mb_substr(str_repeat($pad_str, $repeat), 0, ceil($length));
    } else {
        $repeat = ceil($str_len - $pad_str_len + $pad_len);
        if ($dir == STR_PAD_RIGHT) {
            $result = $str . str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0, $pad_len);
        } else if ($dir == STR_PAD_LEFT) {
            $result = str_repeat($pad_str, $repeat);
            $result = mb_substr($result, 0, 
                        $pad_len - (($str_len - $pad_str_len) + $pad_str_len))
                    . $str;
        }
    }

    return $result;
}