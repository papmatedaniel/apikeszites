<?php
include 'idoszamitas.php';
header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['nap'])){
    $megadottnap = date("Y.m.d");
}else{
    $megadottnap = $_GET['nap'];
}

if (!isset($_GET['ido'])){
    $megadottido = date("H:i");
}else{
    $megadottido = $_GET['ido'];
}

$idopont =  $megadottnap . "." . $megadottido;
[$holdfazis, $valtozas] = aktualholdfazis($idopont);
$tomb = array('idopont' => $idopont, 'holdfazis' => $holdfazis, 'valtozas' => $valtozas);
$json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
print $json;

?>