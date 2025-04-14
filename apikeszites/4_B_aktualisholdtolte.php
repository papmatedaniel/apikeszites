<?php

$datum = "2025.04.14";
$koviTelihold = aktualisholdfazis($datum, 1);
$elozotelihold = aktualisholdfazis(napboldatum(datumbolnap($datum)-30), 1);
$deficit = datumbolnap($datum) - datumbolnap($elozotelihold);
$szazalek = $deficit/(29/100);
echo "A hold jelenleg " . $szazalek . "%-ban van";
?>