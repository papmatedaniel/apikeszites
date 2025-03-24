<!-- Visszatérési érték: következő 3 holdtölte időpontja -->
<!-- 1. Ha van paraméter, akkor a megadott időpontot követő 3 holdtölte időpontja -->
<!-- 2. Ha nincs paraméter, akkor a mai dátumhoz képest számítja ki a kövi. 3 holdtölte dátumát -->
<!-- 1. Lépés: írni egy függvényt, ami megkap egy dátumot, és visszaadja a kövi 3 holdtölte dátumát -->
<?php
// Évet, hónapot nem tudom percé alakítani a szökőévek miatt.  - Már tudok szökőévekkel számolni
//Telihold volt pl. 2021. június 24-én, 20:40-kor. - Percé alakítjuk
//Két azonos fázis közti időtartam (az ún. szinodikus keringésidő) 29.53058867 nap. - Percé alakítjuk
//Megkapunk egy dátumot - Percé alakítjuk
//A 2021. június 24 - percé alakított időpontjához elkezdjük hozzá adogatni a szonikus időt percekben.
//Minden új hozzáadásnál visszaalkaítjuk év, hónap, nap, óra, perc dátummá, és megnézzük, hogy az a kért időpont után van e.7
// Dátum percé alakítása



function datumPerckonverter($datum){
    $datum = explode(".", $datum);
    $ev = (int)$datum[0];
    $honap = (int)$datum[1];
    $nap = (int)$datum[2];
    $ora = (int)$datum[3];
    $perc = (int)$datum[4];
    
    function szokoev($ev) {
        return ($ev % 4 == 0 && $ev % 100 != 0) || ($ev % 400 == 0);
    }
    
    $honap_napok = [
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
    ];
    
    if (szokoev($ev)) {
        $honap_napok[2] = 29;
    }
    
    $napokszama = 0;
    for ($i = 1; $i < $ev; $i++) {
        $napokszama += szokoev($i) ? 366 : 365;
    }
    
    for ($i = 1; $i < $honap; $i++) {
        $napokszama += $honap_napok[$i];
    }
    
    $napokszama += $nap;
    
    $percek = $napokszama * 24 * 60 + $ora * 60 + $perc;
    
    return $percek;
}

echo datumPerckonverter("2021.06.24.20.40");


?>

