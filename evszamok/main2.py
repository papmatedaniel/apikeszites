datum = "1970.03.16"
ev = int(datum[0:4])
honap = int(datum[5:7])
nap = int(datum[8:10])

def szokoeve(ev):
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

# Szökőév esetén február 29 napos
if szokoeve(ev):
    honap_napok[2] = 29

# Az év eleje óta eltelt napok számának kiszámítása
napokszama = 0
for i in range(1, ev):
    if szokoeve(i):
        napokszama += 366
    else:
        napokszama += 365

for i in range(1, honap):
    napokszama += honap_napok[i]

napokszama += nap
print(napokszama)
# Évek, hónapok és napok kiszámítása
evek = 0
napokszama2 = napokszama
while napokszama2 >= 0:
    napokszama = napokszama2
    if szokoeve(evek):
        napokszama2 -= 366
    else:
        napokszama2 -= 365
    evek += 1

honapok = 1
napokszama2 = napokszama
while napokszama2 > 0:
    napok_honapban = honap_napok[honapok]
    if napokszama2 > napok_honapban:
        napokszama2 -= napok_honapban
        honapok += 1
    else:
        break

napok = napokszama2
print(f"{evek}.{honapok}.{napok}")


"""
def szokoeve(ev):
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

def datumbolnap(datum):
    ev = int(datum[0:4])
    honap = int(datum[5:7])
    nap = int(datum[8:10])

    # Az év eleje óta eltelt napok számának kiszámítása
    napokszama = 0
    for i in range(1, ev):
        if szokoeve(i):
            napokszama += 366
        else:
            napokszama += 365

    # Az adott év hónapjainak napjai (február kezelése évfüggetlenül)
    for i in range(1, honap):
        if i == 2:  # Február kezelése
            napokszama += 29 if szokoeve(ev) else 28
        else:
            napokszama += honap_napok[i]

    napokszama += nap
    return napokszama - 1 


def napboldatum(napokszama):
    # Évek, hónapok és napok kiszámítása
    evek = 0
    napokszama2 = napokszama + 1
    while napokszama2 >= 0:
        napokszama = napokszama2
        if szokoeve(evek):
            napokszama2 -= 366
        else:
            napokszama2 -= 365
        evek += 1

    honapok = 1
    napokszama2 = napokszama
    while napokszama2 > 0:
        napok_honapban = honap_napok[honapok]
        if napokszama2 > napok_honapban:
            napokszama2 -= napok_honapban
            honapok += 1
        else:
            break

    napok = napokszama2 + 1
    return f"{evek}.{honapok}.{napok}"
"""