<?php
// paraméter: adóazonosító
// Visszatérési érték: ha érvényes azonosító, akkor abból kiszámolja a születési dátumot, ellenkező esetben hibajelzést dob.
    header('Content-Type: application/json; charset=utf-8');

    if (!isset( $_GET['jel']) ){
        $tomb = array( 'hiba' => "hiányos adatok" ,  'uzenet' => "megadandó paraméterek: kg és cm");
        $json = json_encode( $tomb , JSON_UNESCAPED_UNICODE ) ;
    }
    else {
        $szuletesidatum = substr($_GET['jel'], 0, 6);
        // Meg kell nézni hanyadik karaktertől nem nulla a szám
        $hanyadik = -1;
        for ($i = 1; strlen($szuletesidatum); $i++){
            if($szuletesidatum[$i] != "0"){
                $hanyadik = $i;
                break;
            }
        }
        if($hanyadik == -1){
            // Érvénytelen adószám
            $tomb = array( 'jel' => $_GET['jel'] ,  'üzenet' => 'érvénytelen adószám');
            $json = json_encode( $tomb , JSON_UNESCAPED_UNICODE );
        }
        else{
            $nap = substr($szuletesidatum, $hanyadik, 6);
            $tomb = array( 'jel' => $_GET['jel'] ,  'szul_datum' => $nap);
            $json = json_encode( $tomb , JSON_UNESCAPED_UNICODE ) ;

        }
    }

    print $json;
    ?>