import ccxt
import time
from portableRedis import Portable
import pandas as pd


class Exchange:

    def __init__(self):
        self.exchanges = ['_1broker', '_1btcxe', 'acx', 'allcoin', 'anxpro', 'bibox', 'binance', 'bit2c', 'bitbay', 'bitcoincoid', 'bitfinex', 'bitfinex2', 'bitflyer', 'bithumb', 'bitlish', 'bitmarket', 'bitmex', 'bitso', 'bitstamp', 'bitstamp1', 'bittrex', 'bl3p', 'bleutrade', 'braziliex', 'btcbox', 'btcchina', 'btcexchange', 'btcmarkets', 'btctradeua', 'btcturk', 'btcx', 'bter', 'bxinth', 'ccex', 'cex', 'chbtc', 'chilebit', 'coincheck', 'coinexchange', 'coinfloor', 'coingi', 'coinmarketcap', 'coinmate', 'coinsecure', 'coinspot', 'cryptopia', 'dsx', 'exmo', 'flowbtc', 'foxbit', 'fybse', 'fybsg', 'gatecoin', 'gateio', 'gdax', 'gemini', 'getbtc', 'hitbtc', 'hitbtc2', 'huobi', 'huobicny', 'huobipro', 'independentreserve', 'itbit', 'jubi', 'kraken', 'kucoin', 'kuna', 'lakebtc', 'liqui', 'livecoin', 'luno', 'lykke', 'mercado', 'mixcoins', 'nova', 'okcoincny', 'okcoinusd', 'okex', 'paymium', 'poloniex', 'qryptos', 'quadrigacx', 'quoinex', 'southxchange', 'surbitcoin', 'therock', 'tidex', 'urdubit', 'vaultoro', 'vbtc', 'virwox', 'wex', 'xbtce', 'yobit', 'yunbi', 'zaif', 'zb']
        self.redis = Portable(0)
        

    def _load_markets(self):
        
        for market in self.exchanges:
            try:
                exc = getattr(ccxt, market)
                print(exc)
##                    print(exc)
####                    self._getting_datas_from_markets(exc)
            except Exception as e:
##                print(e)
                pass

    
    def _getting_datas_from_markets(self, exc): 
        tickers = exc.fetch_tickers().keys()
        print(tickers)
##        data = [[1524576000000, 0.075106, 0.075259, 0.07509, 0.0752, 1011.466], [1524576300000, 0.075248, 0.075538, 0.075175, 0.07549, 1739.693], [1524576600000, 0.075488, 0.075723, 0.075415, 0.075688, 1102.184], [1524576900000, 0.075622, 0.075759, 0.075422, 0.075504, 1808.616]]
##        for pair in tickers:
##            print(pair)
##            t = exchange.fetch_ohlcv(pair, '5m')[-5:-1]
##            df=pd.DataFrame()
##            print(t[-1])
##            
##            break
##        df=pd.DataFrame(data)
##        x = df.to_msgpack(compress='zlib')            
##        redis.set('ht',x.hex())
##
##
##        def to_df(key):
##            h = self.get(key)
##            b = bytes.fromhex(h)
##            df = pd.read_msgpack(b)
##            return df

if __name__ == "__main__":
    e = Exchange()
    e._load_markets()

