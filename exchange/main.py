from portableMysql import Portable
import json
import requests as req
import time as t
from threading  import Thread


##Cryptocompare API
## NOTE!!!
## 6000 requests per hour per IP for the historical paths

##get all coins 2400+

p0 = Portable(0)
p3 = Portable(3)
keys = p3.keys()

def get_coins():
    url = "https://www.cryptocompare.com/api/data/coinlist/"
    r = req.get(url).json()["Data"]
    return r




def ticker():
    coins = {}
    for i in range(0,17):
        url = "https://api.coinmarketcap.com/v2/ticker/?start={}01&limit=100".format(i)
        r = req.get(url).json()["data"]
        coins.update(r)
        print("Page : " + str(i)) 
    
    return coins

def save_ticker():
    coins = ticker()
    print("Total Coins : " + str(len(coins)))
    for i in coins.keys():
        p3.set(coins[i]['symbol'], coins[i])
        print("Save for coin : " + str(coins[i]['name']))


def history_USD(coin):
    url = 'https://min-api.cryptocompare.com/data/histoday?fsym={}&tsym=USD&limit=2000&e=CCCAGG'.format(coin)
    try:
        r = req.get(url).json()["Data"]
    except Exception as e:
        print("Error : " + str(e))
        r = ""
    return r

def history_BTC(coin):
    url = 'https://min-api.cryptocompare.com/data/histoday?fsym={}&tsym=BTC&limit=2000&e=CCCAGG'.format(coin)
    try:
        r = req.get(url).json()["Data"]
    except Exception as e:
        print("Error : " + str(e))
        r = ""
    return r

def run_coin():
    print("running coin")
    #0 is for ticker details save to database
    i = 0
    g = get_coins()
    for coin in g.keys():
        print(i)
        print("Get ticker for coin : " + str(coin))
        p0.set(coin, g[coin])
##        t.sleep(0.5)
        i = i + 1


def run_USD():
    print("running USD price")
    #1 is for history details save to database
    p1 = Portable(1)
    for coin in keys:
        print("Get history for coin in USD price: " + str(coin))
        p1.set(coin, history_USD(coin))
        t.sleep(1)

    

def run_BTC():
    print("running BTC price")
    #2 is for history details save to database
    p2 = Portable(2)
    for coin in keys:
        print("Get history for coin in BTC price: " + str(coin))
        p2.set(coin, history_BTC(coin))
        t.sleep(1)




def run():
    
    threads = []
   
    func = [run_USD, run_BTC]

    print("start treading..")
    for f in func:
        t = Thread(target=f, args=())
        t.start()
        threads.append(t)
        
    
    for t in threads:
        t.join()

    


if __name__ == "__main__":
    r = run()
