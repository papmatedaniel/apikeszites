<?php
include 'idoszamitas.php';
header('Content-Type: application/json; charset=utf-8');

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
$tomb = array('telihold' => kovetkezoteliholdak($megadottidopont, $darab));
$json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
print $json;
?>