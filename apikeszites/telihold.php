<!-- Visszatérési érték: következő 3 holdtölte időpontja -->
<!-- 1. Ha van paraméter, akkor a megadott időpontot követő 3 holdtölte időpontja -->
<!-- 2. Ha nincs paraméter, akkor a mai dátumhoz képest számítja ki a kövi. 3 holdtölte dátumát -->
<!-- 1. Lépés: írni egy függvényt, ami megkap egy dátumot, és visszaadja a kövi 3 holdtölte dátumát -->
<?php


$xholdfazis = "2021.06.24.20.40";
// Dátum percé alakítása
$szeleteltIdo = explode(".", $xholdfazis)
$xholdfazispercben = $szeleteltIdo[4] + $szeleteltIdo[3] * 60 + ($szeleteltIdo[3] )
// Évet, hónapot nem tudom percé alakítani a szökőévek miatt.  
?>