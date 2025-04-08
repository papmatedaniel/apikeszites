<?php
function szokoeve($ev){
    return ($ev % 4 == 0 && $ev % 100 != 0) || $ev % 400 == 0;
}
$honap_napok = array(
    1 => 31,
    2 => 28,  # Alapértelmezett február napok száma
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

function datumbolnap($datum){
    /*Visszatérési érték: 0001.01.01 - paraméter(pl 2025.02.25) között eltelt napok száma */
    $ev = intval(explode(".", $datum)[0]);
    $honap = intval(explode(".", $datum)[1]);
    $nap = intval(explode(".", $datum)[2]);

    /* Évek konvertálása napokká */
    $napokszama = 0;
    for ($i=1; $i<$ev; $i++){
        if (szokoeve($i)){
            $napokszama += 366;
        }
        else{
            $napokszama += 365;
        }
    }

    if (szokoev($ev)){
        $honap_napok[2] = 29;
    }

    for ($i=1; $i<$honap; $i++){
        $napokszama += $honap_napok[$i];
    }

    $napokszama += ($nap -1);
    return $napokszama;

}

function napboldatum($napokszama){
    $lista = 0; /*HIÁNYZIK*/

    $evekszama = 1;
    while ($napokszama >= 365){
        $evekszama++;
        if (szokoeve($evekszama)){
            $napokszama -= 366;
        }
        else{
            $napokszama -= 365;
        }
    }
    if (szokoeve($evekszama)){
        $napokszama++;
        array_splice($lista, 59, 0, "2.29."); 
    }

    $honap_nap = $lista[$napokszama];
    return (sprintf("%04d", $evekszama)) . ($honap_nap);

}

function datumbolperc($datum){
    $ora = intval(explode(":", explode(".", $datum)[3])[0]);
    $perc = intval(explode(":", explode(".", $datum)[3])[1]);
    return $percekszama;
}

function percboloraperc($percekszama){
    $ora = $percekszama / 60;
    $perc = $percekszama % 60;
    return [$ora, $perc];
}

function percboldatum($perc){
    $napokszama = $perc / (60 * 24);
    $percekszama = $perc % (60 * 24);
    [$ora, $perc] = percboloraperc($percekszama);
    return (napboldatum($napokszama)) . (sprintf("%02d", $ora)) . (sprintf("%02d", $perc));
}

function adottevteliholdjai($megadottidopont = "2025.04.08", $evek = 3){
    $origo_ido = datumbolperc("2021.06.24.20:40");
    (int)$szinodikus_ido_percben = (29.53058867 * 24 * 60);

    $teliholdak_egy_evben = 365.25 / 29.53058867;
}
?>
