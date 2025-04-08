from datetime import datetime, timedelta

def szokoeve(ev: int) -> bool:
    """Eldönti a paraméterül kapott számról, hogy szökőév e"""
    return (ev % 4 == 0 and ev % 100 != 0) or ev % 400 == 0


# Hónapok napjainak száma szótárban
honap_napok = {
    1: 31,
    2: 28,  # Alapértelmezett február napok száma
    3: 31,
    4: 30,
    5: 31,
    6: 30,
    7: 31,
    8: 31,
    9: 30,
    10: 31,
    11: 30,
    12: 31
}

def datumbolnap(datum: str) -> int:
    """Visszatérési érték: 0001.01.01 - paraméter(pl 2025.02.25) között eltelt napok száma"""
    ev, honap, nap = map(int, datum.split(".")[0:3])

    # Évek konvertálása napokká
    napokszama = 0
    for i in range(1, ev):
        if szokoeve(i):
            napokszama += 366
        else:
            napokszama += 365

    # Szökőév esetén február 29 napos
    if szokoeve(ev):
        honap_napok[2] = 29

    # Hónap konvertálása napokká
    for i in range(1, honap):
        napokszama += honap_napok[i]
    
    honap_napok[2] = 28 

    napokszama += (nap -1) # Maradék napok hozzáadása
    return napokszama

def napboldatum(napokszama: int) -> str:
    """0001.01.01 - x dátum között eltelt napok számából(paraméter) számolja ki az x dátumot"""

    # 01.01 - 12.31 közötti napok legyártása, és sorbarendezett eltárolása a listában
    lista = [f"{i:02}.{j:02}." for i in honap_napok.keys() for j in range(1, honap_napok[i]+1)]
    
    # Évek kiszámolása
    evekszama = 1
    while napokszama >= 365:
        evekszama += 1
        if szokoeve(evekszama):
            napokszama -= 366
        else:
            napokszama -= 365
    
    if szokoeve(evekszama):
        napokszama += 1
        lista.insert(59, "2.29.") # Szökőév esetén a február 29 napos

    # Megmaradt napok számából már csak megkell indexelni az x-ik napot a listából, amivel megkapjuk a pontos napot, hónapot
    honap_nap = lista[napokszama]
    return f"{evekszama:04}.{honap_nap}"


def datumbolperc(datum):
    """Visszatérési érték: 0001.01.01.00:00 - paraméter(pl 2025.02.25.18:20) között eltelt percek száma"""
    ora, perc = map(int, datum.split(".")[3].split(":"))
    percekszama = datumbolnap(datum) * 24 * 60 + ora * 60 + perc
    return percekszama

def percboloraperc(percekszama):
    """Paraméterül kapott perceket átkonvertálja óra, perc formátumba, majd visszatér azzal"""
    ora = percekszama // 60
    perc = percekszama % 60
    return ora, perc

def percboldatum(perc):
    """0001.01.01.00:00 - x dátum(pl 2025.02.19.23:10) között eltelt percek számából számolja ki az x dátumot"""
    napokszama = perc // (60 * 24)
    percekszama = perc % (60 * 24)
    ora, perc = percboloraperc(percekszama)
    return f"{napboldatum(napokszama)}{ora:02}:{perc:02}"


def kovetkezo_telihold(utolso_telihold: str, szinodikus_ido: float) -> str:
    """AI tesztelő függvénye, hogy biztos jó e az enyém:)"""
    """
    Kiszámítja a következő telihold dátumát.
    
    :param utolso_telihold: Az utolsó telihold dátuma és időpontja (YYYY-MM-DD HH:MM formátumban)
    :param szinodikus_ido: A Hold szinodikus keringési ideje napokban
    :return: A következő telihold dátuma és időpontja (YYYY-MM-DD HH:MM formátumban)
    """
    utolso_datum = datetime.strptime(utolso_telihold, "%Y-%m-%d %H:%M")
    kovetkezo_datum = utolso_datum + timedelta(days=szinodikus_ido)
    return kovetkezo_datum.strftime("%Y-%m-%d %H:%M")

    # Példa használat
    utolso_telihold = "2021-06-24 20:40"
    # 2021-07-24 09:24
    szinodikus_ido = 29.53058867
    # print(kovetkezo_telihold(utolso_telihold, szinodikus_ido))


def adottevteliholdjai():

    origo_ido = datumbolperc("2021.06.24.20:40")
    szinodikus_ido_percben = int(29.53058867 * 24  * 60)
    megadottev = int(input("Add meg az évet: ")[0:4])

    """AI: {"""
    # Számoljuk ki, hogy hány telihold periódus van egy évben:
    # 1 év = 365.25 nap (átlagosan) és ennek percben: 365.25*24*60
    # Ezért az egy év alatt bekövetkező teliholdak száma:
    teliholdak_egy_evben = 365.25 / 29.53058867
    
    # A megadott év és 2021 közötti különbség alapján számoljuk ki a korrekciós teliholdok számát
    offset_telihold = int(round((megadottev - 2021) * teliholdak_egy_evben))
    
    # A helyes időpont eléréséhez korrigáljuk az origo_ido-t
    origo_ido += (offset_telihold-6) * szinodikus_ido_percben

    """}: AI"""

    for i in range(15):
        if str(megadottev) == percboldatum(origo_ido)[0:4]:
            print(percboldatum(origo_ido))
        origo_ido += szinodikus_ido_percben


# print(adottevteliholdjai())
def percboldatum(perc):
    """0001.01.01.00:00 - x dátum(pl 2025.02.19.23:10) között eltelt percek számából számolja ki az x dátumot"""
    napokszama = perc // (60 * 24)
    percekszama = perc % (60 * 24)
    ora, perc = percboloraperc(percekszama)
    return f"{napboldatum(napokszama)}{ora:02}:{perc:02}"


def adottevteliholdjai(megadottidopont = "2025.04.08.", evek = 3):
    megadottev = int(megadottidopont.split(".")[0])

    origo_ido = datumbolperc("2021.06.24.20:40")
    szinodikus_ido_percben = int(29.53058867 * 24  * 60)
    # megadottev = int(input("Add meg az évet: ")[0:4])

    """AI: {"""
    # Számoljuk ki, hogy hány telihold periódus van egy évben:
    # 1 év = 365.25 nap (átlagosan) és ennek percben: 365.25*24*60
    # Ezért az egy év alatt bekövetkező teliholdak száma:
    teliholdak_egy_evben = 365.25 / 29.53058867
    
    # A megadott év és 2021 közötti különbség alapján számoljuk ki a korrekciós teliholdok számát
    offset_telihold = int(round((megadottev - 2021) * teliholdak_egy_evben))
    
    # A helyes időpont eléréséhez korrigáljuk az origo_ido-t
    origo_ido += (offset_telihold-6) * szinodikus_ido_percben

    """}: AI"""

    while (evek != 0):
        if (datumbolnap(megadottidopont) * 24 * 60) < origo_ido:
            evek -= 1
            print(percboldatum(origo_ido))
        origo_ido += szinodikus_ido_percben

print(adottevteliholdjai("2010.01.24", 14))
