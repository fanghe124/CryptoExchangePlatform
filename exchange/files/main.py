from portableMysql import Portable
import json
import requests as req
import time as t


##Cryptocompare API
## NOTE!!!
## 6000 requests per hour per IP for the historical paths

##get all coins 2400+
def get_coins():
    url = "https://www.cryptocompare.com/api/data/coinlist/"
    r = req.get(url).json()["Data"]
    return r


def ticker(coin):
    url = 'https://min-api.cryptocompare.com/data/pricemultifull?fsyms={}&tsyms=USD'.format(coin)
    r = req.get(url).json()["RAW"]
    return r

def history(coin):
    url = 'https://min-api.cryptocompare.com/data/histoday?fsym={}&tsym=USD&limit=2000&e=CCCAGG'.format(coin)
    r = req.get(url).json()["Data"]
    return r


def run():
    #0 is for ticker details save to database
    p1 = Portable(0)
    #1 is for history details save to database
    p2 = Portable(1)
    
##    for coin in get_coins().keys():
##        print("Get ticker for coin : " + str(coin))
##        p1.set(coin, ticker(coin))
##        t.sleep(0.5)
        

    for coin in get_coins().keys():
        print("Get history for coin : " + str(coin))
        p2.set(coin, history(coin))
        t.sleep(0.5)
        
    


if __name__ == "__main__":
    r = run()
