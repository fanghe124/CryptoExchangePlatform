<?php
class RoiController extends Controller {
    public function index() {
        $this->setTitle(lang('roi::roi-calculator'));
        $coin = input('coin', 'BTC');
        $answers = array();
        if (request_is_post()) {
            $amount =   input('amount');
            $day = input('day');
            $month = input('month');
            $year = input('year');
            $time = $day.'/'.lang($month).'/'.$year;
            $rawurl = "https://min-api.cryptocompare.com/data/pricehistorical?fsym=%s&tsyms=%s&ts=%s";
            $currency = getCurrency();
            $d = DateTime::createFromFormat('d-M-Y', $day.'-'.lang($month).'-'.$year);
            $dTime =  $d->getTimestamp();

            $url = sprintf($rawurl,$coin, $currency,$dTime);
            $request = request_url($url);
            $url = sprintf($rawurl,$coin, $currency, time());
            $currentRequest  =  request_url($url);
            if ($request) {
                $price = $request[$coin][$currency];
                $c = ($price == 0) ? $amount :  $amount / $price;
                $currentPrice = $currentRequest[$coin][$currency];
                $profit = ($currentPrice * $c) - $amount;
                $answers = array(
                    'amount' => getCurrencySymbol().$amount,
                    'time' => $time,
                    'percent' => ceil(($profit / $amount) * 100),
                    'profit' => format_coin_price($profit)
                );
            }

        }
        return $this->render(view('main::roi/index', array('coin' => $coin, 'answers' => $answers)));
    }
}