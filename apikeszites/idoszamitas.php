<?php

function szokoeve($ev){
    // Eldönti a paraméterül kapott számról, hogy szökőév e
    return ($ev % 4 == 0 && $ev % 100 != 0) || $ev % 400 == 0;
}

function alapHonapNapok(){
    return array(
        1 => 31,
        2 => 28,
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
}

function datumbolnap($datum){
    // Visszatérési érték: 0001.01.01 - paraméter(pl 2025.02.25) között eltelt napok száma

    $honap_napok = alapHonapNapok();
    [$ev, $honap, $nap] = explode(".", $datum);

    // Évek konvertálása napokká
    $napokszama = 0;
    for ($i=1; $i<$ev; $i++){
        if (szokoeve($i)){
            $napokszama += 366;
        }
        else{
            $napokszama += 365;
        }
    }

    if (szokoeve($ev)){
        $honap_napok[2] = 29;
    }

    for ($i=1; $i < $honap; $i++){
        $napokszama += $honap_napok[$i];
    }
    $honap_napok[2] = 28;
    $napokszama += ($nap -1);
    return $napokszama;


}

function napboldatum($napokszama){
    // 0001.01.01 - x dátum között eltelt napok számából(paraméter) számolja ki az x dátumot
    $honap_napok = alapHonapNapok();
    // 01.01 - 12.31 közötti napok legyártása, és sorbarendezett eltárolása a listában
    $lista = [];
    foreach ($honap_napok as $honap => $napok) {
        for ($nap = 1; $nap <= $napok; $nap++) {
            $lista[] = sprintf("%02d.%02d.", $honap, $nap);
        }
    }

    // Évek kiszámolása
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
        array_splice($lista, 59, 0, "2.29."); // Szökőév esetén a február 29 napos
    }
    // Megmaradt napok számából már csak megkell indexelni az x-ik napot a listából, amivel megkapjuk a pontos napot, hónapot
    $honap_nap = $lista[$napokszama];
    return (sprintf("%04d.", $evekszama)) . ($honap_nap);

}

function datumbolperc($datum){
    // Visszatérési érték: 0001.01.01.00:00 - paraméter(pl 2025.02.25.18:20) között eltelt percek száma
    $honap_napok = alapHonapNapok();
    [$ora, $perc] = explode(":", explode(".", $datum)[3]);
    $percekszama = datumbolnap($datum, $honap_napok) * 24 * 60 + $ora * 60 + $perc;
    return $percekszama;
}

function percboloraperc($percekszama){
    // Paraméterül kapott perceket átkonvertálja óra, perc formátumba, majd visszatér azzal
    $ora = floor($percekszama / 60);
    $perc = $percekszama % 60;
    return [$ora, $perc];
}
function percboldatum($perc){
    // 0001.01.01.00:00 - x dátum(pl 2025.02.19.23:10) között eltelt percek számából számolja ki az x dátumot
    $napokszama = floor($perc / (60 * 24));
    $percekszama = $perc % (60 * 24);
    [$ora, $perc] = percboloraperc($percekszama);
    return napboldatum($napokszama) . sprintf("%02d", $ora) . sprintf(":%02d", $perc);
}

function kovetkezoteliholdak($megadottidopont, $darab){
    // A megadott dátum(pl 2025.04.01) után következő x $darab(pl 1) telihold dátumát számolja ki(2025.05.12.07:52)
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

function aktualholdfazis($datum){
    // A megadott dátum alapján kiszámolja a holdfázist.
    // Visszatérési értéke a holdfázis százalékos értéke és a változás iránya
    $koviTelihold = kovetkezoteliholdak($datum, 1);
    $elozotelihold = kovetkezoteliholdak(napboldatum(datumbolnap($datum)-30), 1);
    $egyfazis = datumbolperc($koviTelihold[0]) - datumbolperc($elozotelihold[0]);
    $deficit = datumbolperc($datum) - datumbolperc($elozotelihold[0]);
    $t = ($deficit / $egyfazis) * 100;
    $x = round(abs(100 - $t * 2));  //<- AI
    
    if ($x < 10) {
        $fazis = "újhold";
    } elseif ($x < 50) {
        $fazis = "növekvő";
    } elseif ($x < 60) {
        $fazis = "telihold";
    } elseif ($x < 90) {
        $fazis = "fogyó";
    } else {
        $fazis = "újhold";
    }
    return [$x, $fazis];
}
?>
