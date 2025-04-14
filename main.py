import math
from datetime import datetime

def holdfazis_szamitas(idopont: datetime) -> dict:
    """
    Meghatározza a Hold fázisát egy adott dátum alapján.
    
    Paraméter:
        idopont (datetime): A vizsgált dátum és időpont.
    
    Visszatérési érték:
        dict: {"idopont": ISO formátumban, "holdfazis": százalék, "valtozas": irány}
    """
    # Referencia újhold dátum (NASA alapján, pl. 2000.01.06 18:14 UTC)
    ujhold_ref = datetime(2000, 1, 6, 18, 14)
    holdciklus_napokban = 29.53058867

    # Különbség napokban
    napok = (idopont - ujhold_ref).total_seconds() / (24 * 3600)
    napfazis = napok % holdciklus_napokban

    # Hold fázis százalékos megjelenése (0% újhold, 100% telihold)
    szazalek = round((1 - math.cos(2 * math.pi * napfazis / holdciklus_napokban)) / 2 * 100)

    # Fázis irány meghatározása
    if napfazis < holdciklus_napokban / 2:
        irany = "növekvő"
    else:
        irany = "fogyó"

    # Pontos újhold vagy telihold
    if szazalek <= 1:
        irany = "újhold"
    elif szazalek >= 99:
        irany = "telihold"

    return {
        "idopont": idopont.strftime("%Y-%m-%d %H:%M"),
        "holdfazis": szazalek,
        "valtozas": irany
    }

datum = datetime(2025, 4, 14, 14, 4)
eredmeny = holdfazis_szamitas(datum)
print(eredmeny)
