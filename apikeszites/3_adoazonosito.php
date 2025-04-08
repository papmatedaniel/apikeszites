<?php
header('Content-Type: application/json; charset=utf-8');
include 'idoszamitas.php';

function validazonositoe($azonosito){
    if (strlen($azonosito) == 10 && $azonosito[0] == "8" && ctype_digit($azonosito)){
        $osszeg = 0;
        for ($i = 0; $i < 9; $i++){
            $osszeg += ($i+1) * (int) $azonosito[$i];
        }
        return ($osszeg % 11) == (int) $azonosito[strlen($azonosito)-1];
    }
    return False;
}

$honap_napok = alapHonapNapok();

if (!isset($_GET['jel'])) {
    $tomb = array('hiba' => "hiányos adatok", 'uzenet' => "megadandó paraméter: azonosító, pl ?jel=823456796");
    echo json_encode($tomb);
    exit;
}
if (!validazonositoe($_GET['jel'])){
    $tomb = array('jel' => $_GET['jel'], 'üzenet' => 'érvénytelen adószám');
    echo json_encode($tomb);
    exit;
}

$szuletesidatum = substr($_GET['jel'], 0, 6);
$hanyadik = -1;
for ($i = 1; $i < strlen($szuletesidatum); $i++) {
    if ($szuletesidatum[$i] != "0") {  //Hanyadik karaktertől nem 0
        $hanyadik = $i;
        break;
    }
}

//Időszámítás kezdete - megadott dátum között eltelt napok száma:
$ossznap = datumbolnap("1867.01.01") + (int) substr($szuletesidatum, $hanyadik, 6);
$tomb = array('jel' => $_GET['jel'], 'szul_datum' => napboldatum($ossznap));
$json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
print $json;
?>
