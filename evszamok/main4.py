from datetime import datetime, timedelta

def days_since_christ(birth_year, birth_month, birth_day):
    # Krisztus születésének dátuma
    start_date = datetime(1, 1, 1)
    
    # A megadott dátum
    target_date = datetime(birth_year, birth_month, birth_day)
    
    # A két dátum közötti különbség napokban
    delta = target_date - start_date
    
    return delta.days

# Tesztelés
year = int(input("Add meg az évet: "))
month = int(input("Add meg a hónapot: "))
day = int(input("Add meg a napot: "))

result = days_since_christ(year, month, day)
print(f"A Krisztus születésétől eltelt napok száma: {result}")




def napok_to_datum(napok):
    # Az alap dátum, ami az időszámítás kezdete: 0001-01-01
    alap_datum = datetime(1, 1, 1)
    
    # Az eltelt napok hozzáadása az alap dátumhoz
    datum = alap_datum + timedelta(days=napok)
    
    # Visszaadjuk a dátumot év-hónap-nap formátumban
    return datum.strftime("%Y-%m-%d")

# Példa használat
eltelt_napok = int(input("Add meg az eltelt napok számát: "))
print("A pontos dátum:", napok_to_datum(eltelt_napok))
