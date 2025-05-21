<?php
date_default_timezone_set('Europe/Budapest');

function getLocalDatetimeInputValue() {
    $now = new DateTime();
    return $now->format('Y-m-d\TH:i');
}


function getPhaseImage($phase) {
    $map = [
        'Újhold'            => 'new_moon.png',
        'Első negyed'       => 'first_quarter.png',
        'Telihold'          => 'full_moon.png',
        'Utolsó negyed'     => 'last_quarter.png',
        'Növekvő sarló'     => 'waxing_crescent.png',
        'Fogyó sarló'       => 'waning_crescent.png',
        'Növekvő domború'   => 'waxing_gibbous.png',
        'Fogyó domború'     => 'waning_gibbous.png',
    ];
    return isset($map[$phase]) ? 'images/' . $map[$phase] : 'images/default.png';
}

function fetchMoonData($datetime) {
    list($date, $time) = explode('T', $datetime);
    $date = str_replace('-', '.', $date);
    $url = "http://localhost/sulisprojektek/apikeszites/4_B_aktualisholdfazis.php/?nap={$date}&ido={$time}";
    $json = file_get_contents($url);
    return json_decode($json, true);
}

$selectedDatetime = $_POST['datetime'] ?? getLocalDatetimeInputValue();
$data = fetchMoonData($selectedDatetime);
$phaseName = $data['valtozas'] ?? 'Ismeretlen';
$phaseImage = getPhaseImage($phaseName);

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holdfázis lekérdezése</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 24px;
            max-width: 360px;
            width: 100%;
            text-align: center;
        }
        input[type="datetime-local"], button {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }
        button {
            background-color: #005f99;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #004c7a;
        }
        .moon-card {
            margin-top: 24px;
        }
        .moon-card img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .moon-card h2 {
            margin: 16px 0 8px;
            font-size: 1.5rem;
            color: #333;
        }
        .moon-card p {
            margin: 4px 0;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Holdfázis</h1>
        <form method="post">
            <input id="datetime" name="datetime" type="datetime-local"
                   value="<?php echo htmlspecialchars($selectedDatetime); ?>" required />
            <button type="submit">Lekérdezés</button>
        </form>

        <div class="moon-card">
            <img src="<?php echo $phaseImage; ?>" alt="Holdfázis képe" />
            <h2><?php echo htmlspecialchars($phaseName); ?></h2>
            <p>Dátum és idő: <?php echo htmlspecialchars($data['idopont'] ?? $selectedDatetime); ?></p>
        </div>
    </div>
</body>
</html>
