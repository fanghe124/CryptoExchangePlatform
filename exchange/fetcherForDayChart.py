import ccxt
import time
from portableRedis import Portable
import pandas as pd


class Exchange:

    def __init__(self, database=0):
        self.exchanges = ['acx', 'binance', 'bitfinex', 'bitfinex2',
                          'bithumb', 'bitlish', 'bittrex', 'bleutrade',
                          'braziliex', 'btcturk', 'bxinth', 'ccex', 'cex',
                          'coinexchange', 'coingi', 'coinmarketcap', 'cryptopia',
                          'exmo', 'gatecoin', 'gateio', 'hitbtc', 'hitbtc2', 'kraken',
                          'kucoin', 'liqui', 'livecoin', 'luno', 'okex', 'poloniex',
                          'qryptos', 'southxchange', 'therock', 'wex']
        self.redis = Portable(database)
                
    
    def _tickers(self, mrkt=ccxt.acx()): 
        tickers = mrkt.fetch_tickers()
        return tickers


    def _ohlcv(self, market=ccxt.acx(), pair='BTC/AUD'):
        ## timeframe (5m, 1d)
        x = market.fetch_ohlcv(pair, timeframe='1d', limit=10000)
        return x
        
    def _markets_to_database(self, debug=False):
            redis = self.redis
            for market in self.exchanges:
                try:
                    mrkt = getattr(ccxt, market)()
                    if type(mrkt.fetch_tickers()) == dict:
                        for pair in self._tickers(mrkt).keys():
                            ohlcv = self._ohlcv(market=getattr(ccxt, market)(), pair=pair)
                            print("For {} Saving to portable DB...".format(market))
                            data = pd.DataFrame(ohlcv).to_msgpack(compress="zlib").hex()
                            key = "{}-{}".format(pair, market)
                            redis.set(key, data)
                            print("Save : " + str(key))
                        if debug == True:
                            break
                except Exception as e:
                    print(e)
                    pass

    def fetch_data(self, pair="BTC/AUD"):
        redis = self.redis
        from_hex = redis.get(pair)
        df = pd.read_msgpack(bytes.fromhex(from_hex))
        dic = df.to_dict(orient="split")["data"]
        data = {"symbol":pair,"data":dic}
        return data
        

    def run(self):
        c = self._markets_to_database(debug=False)
        return c

if __name__ == "__main__":
    e = Exchange(0)
    x= e.run()
