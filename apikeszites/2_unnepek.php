<?php
header('Content-Type: application/json; charset=utf-8');
if (!isset( $_GET['ev'] )){
    echo json_encode(["error" => "Meg kell adnod egy paramétert: ev"]);
    exit;
}
//március-június közötti napok előállítása, eltárolása
$evszam = $_GET['ev'];
$honapok = ["március ", "április ", "május ", "június "];
$napok = [31, 30, 31, 30];
$lista = [];
for ($x = 0; $x < 4; $x++){
	for ($i = 1; $i <= $napok[$x]; $i++){
		array_push($lista, $honapok[$x] . "" . $i . ".");
	}
}

//képlet:
$T = $evszam;
$A = $T % 19;
$B = $T % 4;
$C = $T % 7;
$D = (19*$A + 24) % 30;
$E = (2*$B + 4*$C + 6*$D + 5) % 7;
$H = 22 + $D + $E;

if ($E == 6 && $D == 29){
	$H = 50;
}
if ($E == 6 && $D == 28 && $A > 10){
	$H = 49;
}

//Húsvét vasárnap dátumának indexe
if ($H<=31){
	$hvi = array_search("március " . $H . ".", $lista);
}
else{
    $hvi = array_search("április " . ($H-31) . ".", $lista);
}

//Húsvét vasárnap indexéből kiindulva elérjük a többi ünnepnap indexét és dátumát
$tomb = array(
	"ev" => $evszam,
	"nagypentek" => $lista[$hvi-2],
	"husvetvasarnap" => $lista[$hvi],
	"husvethetfo" => $lista[$hvi+1],
	"punkosdvasarnap" => $lista[$hvi+49],
	"punkosdhetfo" => $lista[$hvi+50]
);
$json = json_encode($tomb, JSON_UNESCAPED_UNICODE);
print $json;

?>