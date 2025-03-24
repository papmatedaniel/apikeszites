<?php
header('Content-Type: application/json; charset=utf-8');
$nap_set = isset($_GET['nap']);
$nev_set = isset($_GET['nev']);

if ($nap_set && $nev_set) {
    echo json_encode(["error" => "Csak az egyik paramétert adhatod meg: 'nap' vagy 'nev'."]);
    exit;
}

if (!$nap_set && !$nev_set) {
    echo json_encode(["error" => "Meg kell adnod egy paramétert: 'nap' vagy 'nev'."]);
    exit;
}

$myfile = fopen("nevnapok.csv", "r");
$tomb = [];
while (($line = fgets($myfile)) !== false) {
    $szoveg = explode(";", $line);

    if ($nap_set){  //Dátum szerinti keresés
        $napi = explode("-", $_GET['nap']);

        if ($szoveg[2] == $napi[0] && $szoveg[3] == $napi[1]){
            $tomb = [array(
                        'datum'        => $_GET['nap'] ,
                        'nevnap1'       => $szoveg[0]        ,
                        'nevnap2' => $szoveg[1]
                        )] ;
            break;
        }
        else{
            $tomb = [array(
                'datum'        => $_GET['nap'] ,
                'nevnap1'       =>  "",
                'nevnap2' => ""
                )] ;
        }
    }
    else{ //Név szerinti keresés
        $neve = $_GET['nev'];
        
        $honapok = array(
            "1" => "január",
            "2" => "február",
            "3" => "március",
            "4" => "április",
            "5" => "május",
            "6" => "június",
            "7" => "július",
            "8" => "augusztus",
            "9" => "szeptember",
            "10" => "október",
            "11" => "november",
            "12" => "december"
        );

        if (trim($szoveg[0]) == $neve || trim($szoveg[1]) == $neve){
            array_push($tomb, array(
                'datum'        => $honapok[trim($szoveg[2])] . " " . $szoveg[3]  ,
                'nevnap1'       =>  $szoveg[0],
                'nevnap2' => $szoveg[1]
                ));
        }
    }
}
fclose($myfile);
$json = json_encode(array( 'nevnap' => $tomb), JSON_UNESCAPED_UNICODE);
print $json;
?>