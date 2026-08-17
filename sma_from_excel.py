import pandas as pd
import sys
import json

def main():
    try:
        file_path = sys.argv[1]
        df = pd.read_excel(file_path)
        
        # Asumsi: Kolom 0 = Kategori, Kolom 1 = Nama Menu, Kolom 2 dst = Tanggal (data penjualan)
        date_columns = df.columns[2:]
        if len(date_columns) == 0:
            print(json.dumps({'error': 'Tidak ada data tanggal pada file Excel.'}))
            return
            
        predictions = []
        for index, row in df.iterrows():
            menu_nama = str(row['Nama Menu']).strip()
            
            # Ambil data hari
            sales = pd.to_numeric(row[date_columns], errors='coerce').fillna(0).tolist()
            
            # Prediksi = rata-rata
            if len(sales) > 0:
                avg = round(sum(sales) / len(sales))
                mad = round(sum([abs(x - avg) for x in sales]) / len(sales), 2)
                mse = round(sum([(x - avg)**2 for x in sales]) / len(sales), 2)
            else:
                avg = 0
                mad = 0
                mse = 0
                
            predictions.append({
                'menu_nama': menu_nama,
                'prediksi': int(avg),
                'mad': mad,
                'mse': mse
            })
            
        print(json.dumps({'predictions': predictions}))
        
    except Exception as e:
        print(json.dumps({'error': str(e)}))

if __name__ == '__main__':
    main()
