from datetime import datetime, timedelta

def convert_minutes_to_date(minutes):
    # Az időszámítás kezdete (0. január 1.) mint kezdő dátum
    start_date = datetime(1, 1, 1)  # Év 1, hónap 1, nap 1
    # A megadott percek konvertálása másodpercekké, és hozzáadása a kezdő dátumhoz
    result_date = start_date + timedelta(minutes=minutes)
    
    # A dátum formázása
    return result_date.strftime("%Y-%m-%d %H:%M")

# Példa: 1000000 perc átváltása dátumra
minutes = 1062669400
date_result = convert_minutes_to_date(minutes)

print(f"A {minutes} perc pontos dátuma: {date_result}")
