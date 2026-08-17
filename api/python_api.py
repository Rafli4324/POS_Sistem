from flask import Flask, request, jsonify
import pandas as pd
from sqlalchemy import create_engine
from sqlalchemy.sql import text
from mlxtend.frequent_patterns import fpgrowth, association_rules
import os
import traceback

app = Flask(__name__)

# Option for DATABASE_URL if deployed in Vercel
DATABASE_URL = os.getenv('DATABASE_URL')
if DATABASE_URL:
    db_uri = DATABASE_URL
else:
    # Fallback to local DB logic
    DB_HOST = os.getenv('DB_HOST', '127.0.0.1')
    DB_PORT = os.getenv('DB_PORT', '3306')
    DB_DATABASE = os.getenv('DB_DATABASE', 'pos_db')
    DB_USERNAME = os.getenv('DB_USERNAME', 'root')
    DB_PASSWORD = os.getenv('DB_PASSWORD', '')
    db_uri = f"mysql+pymysql://{DB_USERNAME}:{DB_PASSWORD}@{DB_HOST}:{DB_PORT}/{DB_DATABASE}"

@app.route('/api/python/predict', methods=['POST'])
def predict():
    try:
        if 'excel_file' not in request.files:
            return jsonify({'error': 'No file part'}), 400
        
        file = request.files['excel_file']
        if file.filename == '':
            return jsonify({'error': 'No selected file'}), 400
            
        if file:
            df = pd.read_excel(file)
            
            date_columns = df.columns[2:]
            if len(date_columns) == 0:
                return jsonify({'error': 'Tidak ada data tanggal pada file Excel.'}), 400
                
            predictions = []
            for index, row in df.iterrows():
                menu_nama = str(row['Nama Menu']).strip()
                sales = pd.to_numeric(row[date_columns], errors='coerce').fillna(0).tolist()
                
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
                
            return jsonify({'predictions': predictions})
            
    except Exception as e:
        return jsonify({'error': str(e), 'trace': traceback.format_exc()}), 500

@app.route('/api/python/train', methods=['POST'])
def train():
    try:
        engine = create_engine(db_uri)
        
        query = """
        SELECT sd.sale_id, sd.menu_id 
        FROM sale_details sd
        JOIN sales s ON s.id = sd.sale_id
        """
        df = pd.read_sql(query, engine)
        
        if df.empty:
            return jsonify({'message': 'No data available for training.', 'count': 0})
            
        basket = (df.groupby(['sale_id', 'menu_id'])['menu_id']
                  .count().unstack().reset_index().fillna(0)
                  .set_index('sale_id'))
        
        # Convert to boolean
        basket = basket.map(lambda x: True if x > 0 else False)
        
        frequent_itemsets = fpgrowth(basket, min_support=0.01, use_colnames=True)
        
        if frequent_itemsets.empty:
            return jsonify({'message': 'No frequent itemsets found.', 'count': 0})
            
        rules = association_rules(frequent_itemsets, metric="confidence", min_threshold=0.1)
        if rules.empty:
            return jsonify({'message': 'No association rules found.', 'count': 0})
            
        rules = rules[rules['lift'] > 1.0]
        
        records = []
        for index, row in rules.iterrows():
            antecedents = list(row['antecedents'])
            consequents = list(row['consequents'])
            
            for ant in antecedents:
                for con in consequents:
                    records.append({
                        'antecedent_id': int(ant),
                        'consequent_id': int(con),
                        'support': float(row['support']),
                        'confidence': float(row['confidence']),
                        'lift': float(row['lift'])
                    })
                    
        if not records:
            return jsonify({'message': 'No rules matched criteria.', 'count': 0})
            
        rules_df = pd.DataFrame(records)
        rules_df = rules_df.loc[rules_df.groupby(['antecedent_id', 'consequent_id'])['confidence'].idxmax()]
        
        now = pd.Timestamp.now()
        rules_df['created_at'] = now
        rules_df['updated_at'] = now
        
        with engine.begin() as conn:
            conn.execute(text("TRUNCATE TABLE association_rules"))
            rules_df.to_sql('association_rules', con=conn, if_exists='append', index=False)
            
        return jsonify({'message': 'Successfully trained.', 'count': len(rules_df)})
        
    except Exception as e:
        return jsonify({'error': str(e), 'trace': traceback.format_exc()}), 500

if __name__ == '__main__':
    app.run(debug=True, port=3000)
