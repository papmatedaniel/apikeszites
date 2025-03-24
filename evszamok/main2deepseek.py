datum = "1970.03.16"
ev = int(datum[0:4])
honap = int(datum[5:7])
nap = int(datum[8:10])

def szokoeve(ev):
    return (ev % 4 == 0 and ev % 100 != 0) or ev % 400 == 0

honap_napok = {
    1: 31,
    2: 28,
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

if szokoeve(ev):
    honap_napok[2] = 29

# Dátum -> napok
napokszama = 0
for i in range(1, ev):
    napokszama += 366 if szokoeve(i) else 365

for i in range(1, honap):
    napokszama += honap_napok[i]

napokszama += nap
print(napokszama)

# Napok -> dátum
# Év kiszámítása
year = 1
sum_days = 0
while True:
    days_in_year = 366 if szokoeve(year) else 365
    if sum_days + days_in_year < napokszama:
        sum_days += days_in_year
        year += 1
    else:
        break
day_of_year = napokszama - sum_days

# Hónapok frissítése az új évvel
if szokoeve(year):
    honap_napok[2] = 29
else:
    honap_napok[2] = 28

# Hónap és nap kiszámítása
honapok = 1
remaining_days = day_of_year
while remaining_days > honap_napok[honapok]:
    remaining_days -= honap_napok[honapok]
    honapok += 1

print(f"{year}.{honapok:02d}.{remaining_days:02d}")