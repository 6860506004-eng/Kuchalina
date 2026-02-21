from flask import Flask, render_template_string
import pymysql

app = Flask(__name__)

@app.route('/')
def home():
   
    host = "s6860506004db-kuchalina-hwzz2w"
    user = "Nina6860506004"
    password = "1859900347014"
    database = "Nina"

   
    try:
        connection = pymysql.connect(host=host, user=user, password=password, database=database)
        db_status = "<div style='background: white; padding: 10px; color: green; text-align: center; font-weight: bold;'>เชื่อมต่อฐานข้อมูล MariaDB สำเร็จ! (ด้วย Python Flask 🐍)</div>"
        connection.close()
    except Exception as e:
        db_status = f"<div style='background: #fee2e2; padding: 10px; color: #dc2626; text-align: center;'>เชื่อมต่อฐานข้อมูลล้มเหลว: {e}</div>"

  
    try:
        with open('index.html', 'r', encoding='utf-8') as file:
            html = file.read()
       
            html = html.replace('<body>', f'<body>\n{db_status}')
            return render_template_string(html)
    except Exception as e:
        return f"<h1>ไม่พบไฟล์ index.html: {e}</h1>"

if __name__ == '__main__':
  
    app.run(host='0.0.0.0', port=8000)
