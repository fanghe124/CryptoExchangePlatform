<?php

function getCurrency() {
    $currency = config('base_currency', 'USD');
    if (isset($_COOKIE['base_currency'])) {
        $currency = $_COOKIE['base_currency'];
    }
    if (app()->countryCurrency) $currency = app()->countryCurrency;
    return $currency;
}

function getCurrencySymbol($force = false) {
    if (app()->currencySymbol and !$force) return app()->currencySymbol;
    $currency = getCurrency();
    $c = get_coin_fiat_currency_detail($currency);
    if ($c) return $c['symbol'];
    $query = db()->query("SELECT symbol FROM currencies WHERE code=?", $currency);
    $fetch =   $query->fetch(PDO::FETCH_ASSOC);
    $symbol = $fetch['symbol'];
    app()->currencySymbol = $symbol;
    return $symbol;
}

function find_currency($code) {
    $c = get_coin_fiat_currency_detail($code);
    if ($c) return $c;
    $query = db()->query("SELECT * FROM currencies WHERE code=?", $code);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function getCurrencyDetail() {
    if (app()->currencyDetail) return app()->currencyDetail;
    $currency = getCurrency();
    $c = get_coin_fiat_currency_detail($currency);
    if ($c) return $c;
    $query = db()->query("SELECT * FROM currencies WHERE code=?", $currency);
    $detail =  $query->fetch(PDO::FETCH_ASSOC);
    $detail['rate'] = (!$detail['rate']) ? 1 : $detail['rate'];
    app()->currencyDetail = $detail;
    return $detail;
}

function getAllSymbolCodes() {
    $query = db()->query("SELECT symbol FROM coins");
    $codes = array();
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $codes[] = $fetch['symbol'];
    }
    return $codes;
}

function getAllCurrencies($main = false){
    $query = db()->query("SELECT * FROM currencies");
    $currencies = $query->fetchAll(PDO::FETCH_ASSOC);
    return $currencies;
}

function get_coin_currencies() {
    if (isset(app()->fiatCoins)) return app()->fiatCoins;
    $coins = explode(',', config('coin-fiat-currency', 'BTC,ETH,LTC'));
    $result = array();
    //return $result;
    foreach($coins as $coin) {
        $dcoin = get_coin($coin);
        $detail = array(
            'name' => $coin,
            'code' => $coin,
            'rate' => 1,
            'symbol' => ''
        );
        if ($coin == 'BTC') $detail['symbol']  = 'Ƀ';
        if ($coin == 'ETH') $detail['symbol']  = 'Ξ';
        if ($coin == 'LTC') $detail['symbol']  = 'Ł';
        $result[] = $detail;
    }
    app()->fiatCoins = $result;
    return $result;
}

function get_coin_fiat_currency_detail($currency) {
    foreach(get_coin_currencies() as $c) {
        if ($c['name'] == $currency) return $c;
    }
    return false;
}

function is_fiat_currency_coin() {
    $currency = getCurrency();
    $c = get_coin_fiat_currency_detail($currency);
    if ($c) return true;
    return false;
}

function update_rates_data($force = false) {

    if (config('rate_app_id', '')) {

        @mkdir(path('storage/uploads/'), 0777, true);
        $file = @fopen(path('storage/uploads/rates.txt'), 'x+');
        if ($file) fclose($file);;
        $content = file_get_contents(path('storage/uploads/rates.txt'));
        if (!$content or $content < (time() - 3600) or $force) {
            $appID = config('rate_app_id', '');
            $currency = 'USD';
            $url = sprintf(app()->CURRENCIES_MARKET_DATA_URL, $appID, $currency);
            try {
                $request = request_url($url);

                if ($request and isset($request['rates'])) {
                    foreach($request['rates'] as $code => $rate) {
                        db()->query("UPDATE currencies SET rate=? WHERE code=?", $rate, $code);
                    }
                }
                file_put_contents(path('storage/uploads/rates.txt'), time());
            } catch(Exception $e) {

            }
        }

    }
}

function update_coins_data() {

    $request = request_url(app()->COINS_MARKET_DATA_URL);
    if ($request) {
        foreach($request as $coin) {
            $symbol = $coin['symbol'];
			$symbolname = $coin['name'];
            $query = db()->query("SELECT id FROM coins WHERE name=? ", $symbolname);
            if ($query and $query->rowCount() > 0) {
                try{
                    db()->query("UPDATE coins SET change_1h=?,change_24h=?,change_7d=?,price_btc=?,total_supply=?,supply=?,market_cap=?,volume=?,price=?,Maxsupply=? WHERE name=? AND symbol=?",
                        $coin['percent_change_1h'],$coin['percent_change_24h'],$coin['percent_change_7d'],$coin['price_btc'],$coin['total_supply'],
                        $coin['available_supply'],$coin['market_cap_usd'],$coin['24h_volume_usd'],$coin['price_usd'],$coin['max_supply'],$symbolname,$symbol);
                    update_coin_performances($symbol, $coin['price_usd']);
                } catch(Exception $e) {}
            } else {
                try{
                    db()->query("INSERT INTO coins (symbol,name,change_1h,change_24h,change_7d,price_btc,total_supply,supply,market_cap,volume,price,Maxsupply) VALUES ('".$coin['symbol']."', '".$coin['name']."','".$coin['percent_change_1h']."','".$coin['percent_change_24h']."','".$coin['percent_change_7d']."','".$coin['price_btc']."','".$coin['total_supply']."','".$coin['available_supply']."','".$coin['market_cap_usd']."','".$coin['market_cap_usd']."','".$coin['24h_volume_usd']."','".$coin['price_usd']."')");
                    update_coin_performances($symbol, $coin['price_usd']);
                } catch(Exception $e) {}
            }

        }
    }
    return true;
}

function update_global_data() {
    if(!file_exists(path('storage/data/global.txt'))) {
        @mkdir(path('storage/data/'), 0777, true);
        $file = @fopen(path('storage/data/global.txt'), 'x+');
        fclose($file);
    }

    $request = request_url('https://api.coinmarketcap.com/v1/global/');
    if ($request) {
        $content = perfectSerialize($request);
        return file_put_contents(path('storage/data/global.txt'), $content);
    }
}

function update_coin_performances($symbol, $price) {

    if(!file_exists(path('storage/history/coins/'.$symbol.'.txt'))) {
        @mkdir(path('storage/history/coins/'), 0777, true);
        $file = @fopen(path('storage/history/coins/'.$symbol.'.txt'), 'x+');
        fclose($file);
    }

    $content = file_get_contents(path('storage/history/coins/'.$symbol.'.txt'));
    $content .= ($content) ? ','.$price : $price;
    $explode = explode(',', $content);

  
    $content = implode(',', $explode);
    //exit($content.$symbol);
    return file_put_contents(path('storage/history/coins/'.$symbol.'.txt'), $content);
}

function get_coin_line_data($symbol) {
    $file = path('storage/history/coins/'.$symbol.'.txt');
    if (!file_exists($file)) return 0;
    $explode = explode(',', file_get_contents($file));
    $result = array();
    $currency = getCurrencyDetail();
    $rate = $currency['rate'];

    foreach($explode as $price) {

        $dprice = $price * $rate;

        $result[] = number_format($dprice, config('decimal-point', 3), '.', '');
    }
    return implode(',', $result);
}

function get_coins($order = 'market_cap', $orderType = 'ASC',  $limit = 100, $offset = 0, $type = '') {
    $hiddens = get_sql_hidden_coins();
    $sql = "SELECT * FROM coins WHERE symbol NOT IN ($hiddens) ";

    if (!$type or $type == 'coins') {
        $sql .= " ORDER BY $order $orderType LIMIT $limit OFFSET $offset";
    } else {
        if ($type == 'gainers') {
            $sql .= " AND change_24h !='' AND volume >= 10000 ORDER BY change_24h DESC LIMIT 50 ";
        } else {
            $sql .= " AND change_24h !='' AND volume >= 10000 ORDER BY change_24h ASC  LIMIT 50 ";
        }
    }

    $query = db()->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_similar_coin($coin, $limit) {
    $hiddens = get_sql_hidden_coins();
    $sql = "SELECT * FROM coins WHERE symbol NOT IN ($hiddens) AND symbol != '$coin'";

    $sql .= " ORDER BY market_cap DESC LIMIT $limit ";

    $query = db()->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}


function get_coin_rank($coin) {
    if (!app()->currentListedCurrency) {
        $hiddens = get_sql_hidden_coins();
        $query = db()->query("SELECT symbol FROM coins WHERE symbol NOT IN ($hiddens) ORDER BY market_cap DESC");
        $result = array();
        while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
            $result[] = $fetch['symbol'];
        }
        app()->currentListedCurrency = $result;
    }
    return array_search($coin, app()->currentListedCurrency)+1;
}
function get_hidden_coins() {
    return explode(',', config('hide-coins', 'WBTC,ARENA,AMIS,BITCNY,XUC,VERI,ABC,SPANK,DAR,UFR,EMT,GMT,XNN,ITT,NTWK,walo,WBTC*,EFYT'));
}

function get_sql_hidden_coins() {
    $result = "'twlo'";
    $hidden = get_hidden_coins();
    foreach($hidden as $hide) {
        $result .= ",'$hide'";
    }
    return $result;
}
function search_coins($term) {
    $hiddens = get_sql_hidden_coins();
    $query = db()->query("SELECT * FROM coins WHERE (symbol LIKE '%$term%' OR name LIKE '%$term%') AND symbol NOT IN ($hiddens) LIMIT 50");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_featured_coins() {
    $query = db()->query("SELECT * FROM coins WHERE featured=?", 1);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}
function get_all_coins() {
    $query = db()->query("SELECT id,name,symbol FROM coins");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_all_coins_list($offset, $term) {
    $hiddens = get_sql_hidden_coins();
    $sql = "SELECT * FROM coins WHERE symbol NOT IN ($hiddens) ";
    if ($term) {
        $sql .= " AND (name LIKE '%$term%' OR symbol LIKE '%$term%') ";
    }


    $sql .= " ORDER BY price DESC LIMIT 50 OFFSET $offset ";
    $query = db()->query($sql);
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_coin($coin) {
    $query = db()->query("SELECT * FROM coins WHERE symbol=? OR id=? ", $coin, $coin);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_coin_stats() {
    $currencyRate = getCurrencyDetail();
    $displayCurrencyRate = $currencyRate['rate'];
    $hiddens = get_sql_hidden_coins();
    $result = db()->query("SELECT count(symbol) AS total_coins FROM coins WHERE active = 1 AND symbol NOT IN ($hiddens)")->fetch(PDO::FETCH_ASSOC);
    $result = array(
        'total_coins' => $result['total_coins'],
        'total_volume' => 0,
        'total_market_cap' => 0,
        'bitcoin' => '44.84',
        'market' => '9782'
    );
    $data = @perfectUnserialize(file_get_contents(path('storage/data/global.txt')));
    if($data) {
        $result['total_volume'] = $data['total_24h_volume_usd'] * $displayCurrencyRate;
        $result['total_market_cap'] = $data['total_market_cap_usd'] * $displayCurrencyRate;
        $result['bitcoin'] = $data['bitcoin_percentage_of_market_cap'];
        $result['market'] = $data['active_markets'];
    }
    return $result;
}

function get_coin_market_share($coin) {
    $stats = get_coin_stats();
    return round((100 * $coin['market_cap']) / $stats['total_market_cap'], 2);
}

function format_coin_price($price, $symbol = true, $format = true, $decimal = null, $currency = null) {
    $currency = ($currency) ? $currency : getCurrencyDetail();
    $price = $price * $currency['rate'];
    $decimal = ($decimal) ? 0 : config('decimal-point', 3);
    if ($format) $price = formatNumber($price, $decimal);
    $out = ($symbol) ? getCurrencySymbol() : '';
    return $out.$price;
}


function get_coin_history($symbol, $type = 'histoday', $maxDataPoints = 2000, $aggregatePoints = 1, $allData = FALSE) {
    $currency = getCurrencyDetail();
    $rate = $currency['rate'];
    $requestUrl = sprintf(app()->COINS_HISTORICAL_MARKET_DATA_URL, $type, $symbol, config('base_currency','USD'), $maxDataPoints, $aggregatePoints, ($allData?'true':'false'));
    $response = request_url($requestUrl);
    $result = array(

    );

    if ($response and isset($response['Data'])) {
        foreach($response['Data'] as $item) {
            $result[] = [
                'date' => $item['time'] * 1000,
                'date_fmt' => timeStamp('@'.$item['time'], NULL, NULL, NULL, 'Y-m-d'),
                'value' => floatval($item['close']) * $rate,
                'open' => floatval($item['open']) ,
                'low' => floatval($item['low']) ,
                'high' => floatval($item['high']) ,
                'value_fmt' => formatNumber(floatval($item['close']) * $rate, 2),
                'volume' => floatval($item['volumeto']) * $rate,
                'volume_fmt' => formatNumber(floatval($item['volumeto']) * $rate),
                'interval' => $type
            ];
        }
    }
    return $result;
}

function count_all_coins() {
    $query = db()->query("SELECT id FROM coins");
    return $query->rowCount();
}

function get_risers() {
    $hiddens = get_sql_hidden_coins();
    $query = db()->query("SELECT symbol, name, change_ptc,logo FROM coins WHERE active = 1 AND change_ptc IS NOT NULL AND symbol NOT IN ($hiddens) ORDER BY change_ptc DESC LIMIT 20");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_fallers() {
    $hiddens = get_sql_hidden_coins();
    $query = db()->query("SELECT symbol, name, change_ptc,logo FROM coins WHERE active = 1 AND change_ptc IS NOT NULL AND symbol NOT IN ($hiddens) ORDER BY change_ptc ASC LIMIT 20");
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function coin_link($coin, $slug = '') {
    return url(config('coin-link', 'coin').'/'.strtolower($coin['symbol']).'/'.$slug);
}
function get_coin_forums($type) {
    $limit = 50;
    $offset = input('offset', 0);
    try{
        $query = db()->query("SELECT DISTINCT(coin_id) as coin_id FROM posts WHERE post_type=? LIMIT $limit OFFSET $offset", $type);
        $result = array();
    } catch(Exception $e) {
        exit($e->getMessage());
    }
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $detail = array(
            'item' => array(),
            'last' => array(),
            'posts' => 0,
            'comments' => 0
        );
        if ($type == 'coin') {
            $detail['item'] = get_coin($fetch['coin_id']);
            $detail['item']['link'] = coin_link($detail['item'], 'forum');
        }
        $detail['last'] = get_last_post($type,$fetch['coin_id']);
        $detail['posts'] = count_single_forum_posts($type, $fetch['coin_id']);
        $detail['comments'] = count_forum_comments($type,$fetch['coin_id']);
        $result[] = $detail;
    }
    return $result;
}

function get_last_post($type,$id) {
    $query = db()->query("SELECT user_id,date_created FROM posts WHERE post_type=? AND coin_id=? ORDER BY id DESC LIMIT 1", $type,$id);
    return $query->fetch(PDO::FETCH_ASSOC);
}

function count_single_forum_posts($type, $typeId) {
    $query = db()->query("SELECT user_id,date_created FROM posts WHERE post_type=? AND coin_id=?", $type,$typeId);
    return $query->rowCount();
}
function count_forum_posts($type) {
    $query = db()->query("SELECT DISTINCT(coin_id) FROM posts WHERE post_type=?", $type);
    return $query->rowCount();
}

function count_forum_comments($type,$typeId = '') {
    $postIds = array(0);
    $query = db()->query("SELECT id FROM posts WHERE coin_id=? AND post_type=?", $typeId, $type);
    while($fetch = $query->fetch(PDO::FETCH_ASSOC)) {
        $postIds[] = $fetch['id'];
    }
    $postIds = implode(',', $postIds);
    $query = db()->query("SELECT id FROM comments WHERE post_id IN ($postIds)");
    return $query->rowCount();
}

function get_highest_coins() {
    $coins = array();
    $selected = explode(',', config('trending-coin', 'BTC,ETH,XRP,BCH,ADA'));
    foreach($selected as $se) {
        $coins[] = get_coin($se);
    }
    return $coins;
}

function available_table_columns() {
    return array(
        'name',
        'price',
        'change_ptc',
        'supply',
        'volume',
        'market_cap',
        'action'
    );
}


function my_table_columns() {
    $columns = array(
        'name',
        'price',
        'market_cap',
        'supply',
        'volume',
        'change_24h'
    );

    if (isset($_COOKIE['table-columns'])) {
        $columns = explode(',', $_COOKIE['table-columns']);
    }
    return $columns;
}

function get_coin_logo($coin) {
    if ($coin['logo']) {
        return url('public/assets/images'.$coin['logo']);
    } else {
        return url('public/assets/images/coin.jpg');
    }
}


function get_default_market() {
    return "Cryptsy,trustdex,Exx,bisq,BTCChina,kucoin,Bitstamp,BTER,OKCoin,Coinbase,Poloniex,Cexio,BTCE,BitTrex,Kraken,Bitfinex,Yacuna,LocalBitcoins,Yunbi,itBit,HitBTC,btcXchange,BTC38,Coinfloor,Huobi,CCCAGG,LakeBTC,ANXBTC,Bit2C,Coinsetter,CCEX,Coinse,MonetaGo,Gatecoin,Gemini,CCEDK,Cryptopia,Exmo,Yobit,Korbit,BitBay,BTCMarkets,Coincheck,QuadrigaCX,BitSquare,Vaultoro,MercadoBitcoin,Bitso,Unocoin,BTCXIndia,Paymium,TheRockTrading,bitFlyer,Quoine,Luno,EtherDelta,bitFlyerFX,TuxExchange,CryptoX,Liqui,MtGox,BitMarket,LiveCoin,Coinone,Tidex,Bleutrade,EthexIndia,Bithumb,CHBTC,ViaBTC,Jubi,Zaif,Novaexchange,WavesDEX,Binance,Lykke,Remitano,Coinroom,Abucoins,BXinth,Gateio,HuobiPro,OKEX";
}

function count_available_exchanges() {
    return count(explode(',', get_default_market()));
}

function get_available_exchanges() {

    return array(
        "Cryptsy" => '',
        "BTCChina" => '',
        "Bitstamp"=>'https://www.bitstamp.net/',
        "BTER"=>'https://bter.com/',
        "OKCoin"=> '',
        "Coinbase"=>'',
        "Poloniex" => 'https://poloniex.com/',
        "Cexio"=> 'https://cex.io/r/0/up110861111/0/',
        "BTCE"=> 'https://btc-e.com/',
        "BitTrex" => 'https://bittrex.com/',
        "Kraken"=> 'https://www.kraken.com/',
        "Bitfinex" => 'https://www.bitfinex.com/',
        "Yacuna"=>'https://yacuna.com/',
        "LocalBitcoins"=> '',
        "Yunbi"=>'https://yunbi.com/',
        "itBit" => '',
        "HitBTC" => 'https://hitbtc.com/',
        "btcXchange" => '',
        "BTC38"=> 'http://www.btc38.com/',
        "Coinfloor" => 'https://coinfloor.co.uk/',
        "Huobi" => '',
        "CCCAGG" => '',
        "LakeBTC" => '',
        "ANXBTC" => '',
        "Bit2C" => '',
        "Coinsetter" => '',
        "CCEX" => '',
        "Coinse" => '',
        "MonetaGo" => '',
        "Gatecoin" => 'https://gatecoin.com/',
        "Gemini" => '',
        "CCEDK" => 'https://www.ccedk.com/',
        "Cryptopia" => 'https://www.cryptopia.co.nz/Exchange',
        "Exmo" => 'https://exmo.com/',
        "Yobit" => 'https://yobit.io/',
        "Korbit" => '',
        "BitBay" => 'https://affiliate.bitbay.net/11543',
        "BTCMarkets" => 'https://www.btcmarkets.net/',
        "Coincheck" => 'https://coincheck.com/',
        "QuadrigaCX" => '',
        "BitSquare" => '',
        "Vaultoro" => '',
        "MercadoBitcoin" => '',
        "Bitso" => '',

        "Unocoin" => '',
        "BTCXIndia" => '',
        "Paymium" => '',
        "TheRockTrading" => 'https://www.therocktrading.com/referral/450',
        "bitFlyer"=> '',
        "Quoine" => '',
        "Luno" => '',
        "EtherDelta" => 'https://etherdelta.github.io/',
        "bitFlyerFX" => '',
        "TuxExchange"=>'https://tuxexchange.com/',
        "CryptoX" => 'https://cryptox.pl/',
        "Liqui" => 'https://liqui.io/',
        "MtGox" => '',
        "BitMarket" => 'https://www.bitmarket.net/',
        "LiveCoin" => 'https://livecoin.net/',
        "Coinone" => '',
        "Tidex" => 'https://tidex.com/',
        "Bleutrade" => 'https://bleutrade.com/',
        "EthexIndia" => '',
        "Bithumb" => '',
        "CHBTC" => '',
        "ViaBTC" => '',
        "Jubi" => 'https://www.jubi.com/',
        "Zaif" => 'https://zaif.jp/',
        "Novaexchange" => 'https://novaexchange.com/',
        "WavesDEX" => 'https://wavesplatform.com/',
        "Binance" => 'https://www.binance.com/',
        "Lykke" => 'https://www.lykke.com/',
        "Remitano" => 'https://remitano.com/',
        "Coinroom" => 'https://coinroom.com/',
        "Abucoins" => 'https://abucoins.com/',
        "BXinth" => 'https://bx.in.th/',
        "Gateio" => 'https://gate.io/',
        "HuobiPro" => '',
        "OKEX" => 'https://www.okex.com/',
        'trustdex' => 'https://trustdex.io/',
        'exx' => 'https://www.exx.com/',
        'kucoin' => 'https://www.kucoin.com/',
        'bisq' => 'https://bisq.network/',
    );
}
