<?php

include 'idoszamitas.php';


$datum = "2025.04.14.14:04";
$koviTelihold = adottevteliholdjai($datum, 1);
$elozotelihold = adottevteliholdjai(napboldatum(datumbolnap($datum)-30), 1);
$deficit = datumbolperc($datum) - datumbolperc($elozotelihold[0]);
$szazalek = $deficit/((29*60*24)/100);

echo "A hold jelenleg " . $szazalek . "%-ban van";

?>