<?php
include 'idoszamitas.php';
header('Content-Type: application/json; charset=utf-8');

function adottevteliholdjai($megadottidopont, $darab){
    $megadottev = (int)explode(".", $megadottidopont)[0];
    $origo_ido = datumbolperc("2021.06.24.20:40");
    $szinodikus_ido_percben = (int)(29.53058867 * 24 * 60);
    $teliholdak_egy_evben = 365.25 / 29.53058867;
    $offset_telihold = (int)round(($megadottev - 2021) * $teliholdak_egy_evben);
    $origo_ido += ($offset_telihold-6) * $szinodikus_ido_percben;
    $teliholdak = array();
    while ($darab != 0){
        if ((datumbolnap($megadottidopont) * 24 * 60) < $origo_ido){
            $darab -= 1;
            array_push($teliholdak, percboldatum($origo_ido));
        }
        $origo_ido += $szinodikus_ido_percben;
    }
    return $teliholdak;
}


if (!isset($_GET['datum'])){
    $megadottidopont = date("Y.m.d");
}else{
    $megadottidopont = $_GET['datum'];
}

if (!isset($_GET['db'])){
    $darab = 3;
}else{
    $darab = $_GET['db'];
}
$tomb = array('telihold' => adottevteliholdjai($megadottidopont, $darab));
$json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
print $json;
?>