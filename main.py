from flask import Flask, g, Response
import sqlite3

app = Flask(__name__)

@app.route('/')
def index():
    response = Response("test")
    response.headers["Access-Control-Allow-Origin"] = '*'
    response.headers["Content-Type"] = 'application/json'
    return response





if __name__ == "__main__":
    app.debug = True
    app.run('0.0.0.0',port=5000)
