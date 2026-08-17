import pandas as pd
import sys

try:
    df = pd.read_excel(r'e:\Program Skripsi\data menu.xlsx')
    print(df.to_json(orient='records'))
except Exception as e:
    print(f"Error: {e}")
