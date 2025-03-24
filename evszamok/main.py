from flask import Flask, request, jsonify
from datetime import datetime, timedelta

app = Flask(__name__)

def is_valid_adoazonosito(adoazonosito):
    # 1. Hossz ellenőrzése (10 számjegy)
    if len(adoazonosito) != 10 or not adoazonosito.isdigit():
        return False
    
    # 2. Ellenőrző számjegy kiszámítása
    total = 0
    for i in range(9):
        total += int(adoazonosito[i]) * (i + 1)
    
    remainder = total % 11
    if remainder == 10:  # Érvénytelen, ha a maradék 10
        return False
    
    return remainder == int(adoazonosito[9])

def get_szul_datum(adoazonosito):
    # 2-6. számjegyek kinyerése (1867.01.01. óta eltelt napok)
    days_since_1867 = int(adoazonosito[1:6])
    base_date = datetime(1867, 1, 1)
    szul_datum = base_date + timedelta(days=days_since_1867)
    return szul_datum.strftime("%Y.%m.%d.")

@app.route('/api/adoazonosito/', methods=['GET'])
def check_adoazonosito():
    adoazonosito = request.args.get('jel', '')
    
    if not is_valid_adoazonosito(adoazonosito):
        return jsonify({"jel": adoazonosito, "szul_datum": "", "error": "1"})
    
    szul_datum = get_szul_datum(adoazonosito)
    return jsonify({"jel": adoazonosito, "szul_datum": szul_datum, "error": "0"})

if __name__ == '__main__':
    app.run(debug=True)