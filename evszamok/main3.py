def datumbolperc(datum):
    ev = int(datum[0:4])
    honap = int(datum[5:7])
    nap = int(datum[8:10])
    ora = int(datum[11:13])
    perc = int(datum[14:16])

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

    napokszama += nap - 1

    #Percbe átváltani a dátomot
    percek = napokszama * 24 * 60 + ora * 60 + perc
    return percek



def percboldatum(perc):
    pass










print(datumbolperc("2021.06.24.20:40"))

