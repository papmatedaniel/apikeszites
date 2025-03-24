<?php
header('Content-Type: application/json; charset=utf-8');

function szokoeve($ev) {
    return ($ev % 4 == 0 && $ev % 100 != 0) || $ev % 400 == 0;
}

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

$honap_napok = array(
    1 => 31,
    2 => 28,  // Alapértelmezett február napok száma
    3 => 31,
    4 => 30,
    5 => 31,
    6 => 30,
    7 => 31,
    8 => 31,
    9 => 30,
    10 => 31,
    11 => 30,
    12 => 31
);

if (!isset($_GET['jel'])) {
    $tomb = array('hiba' => "hiányos adatok", 'uzenet' => "megadandó paraméter: azonosító, pl ?jel=823456796");
    $json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
} else {
    if (!validazonositoe($_GET['jel'])){
        $tomb = array('jel' => $_GET['jel'], 'üzenet' => 'érvénytelen adószám');
        $json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
    }
    else{
        $szuletesidatum = substr($_GET['jel'], 0, 6);
        $hanyadik = -1;
        for ($i = 1; $i < strlen($szuletesidatum); $i++) {
            if ($szuletesidatum[$i] != "0") {  //Hanyadik karaktertől nem 0
                $hanyadik = $i;
                break;
            }
        }
        //Időszámítás kezdete - megadott dátum között eltelt napok száma:
        $ossznap = 681543 + (int) substr($szuletesidatum, $hanyadik, 6) + 1;

        //Évek kiszámítása
        $evek = 0;
        $napokszama2 = $ossznap;
        while ($napokszama2 >= 0) {
            $ossznap = $napokszama2;
            if (szokoeve($evek)) {
                $napokszama2 -= 366;
            } else {
                $napokszama2 -= 365;
            }
            $evek++;
        }

        //Hónapok kiszámítása
        $honapok = 1;
        $napokszama2 = $ossznap;
        while ($napokszama2 > 0) {
            $napok_honapban = $honap_napok[$honapok];
            if ($napokszama2 > $napok_honapban) {
                $napokszama2 -= $napok_honapban;
                $honapok++;
            } else {
                break;
            }
        }
        $napok = $napokszama2; //A maradék az a nap
        $szuletesidatuma = "{$evek}.{$honapok}.{$napok}";
        $tomb = array('jel' => $_GET['jel'], 'szul_datum' => $szuletesidatuma);
        $json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
    }
}
print $json;
?>
