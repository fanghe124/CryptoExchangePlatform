<?php
class CoinController extends Controller {
    public function index() {
        app()->activeMenu = 'market';
        $coin = strtoupper(segment(1));
        $coin = get_coin($coin);
        if (!$coin) return redirect(url(''));
        $pageTitle = ($coin['seo_title']) ? $coin['seo_title'] : $coin['name'].' ('.$coin['symbol'].') '.lang('info-quotes-chart');
        $pageDesc = ($coin['seo_description']) ? $coin['seo_description'] : $coin['name'].' ('.$coin['symbol'].') '.lang('info-quotes-chart');

        $metas = "<meta property='og:url' content='".coin_link($coin)."'/>";
        $metas .= "<meta property='og:type' content='article'/>";
        $metas .= "<meta property='og:title' content='$pageTitle'/>";
        $metas .= "<meta property='og:description' content='$pageDesc'/>";
        $metas .= "<meta property='og:image' content='".url($coin['logo'])."'/>";

        Layout::getInstance()->addHeaderContent($metas);
        Layout::getInstance()->favicon = url($coin['logo']);
        $this->setTitle($pageTitle);

        return $this->render(view('main::coin/index', array('coin' => $coin)));
    }

    public function getHistory() {
        $symbol = input('symbol');
        return json_encode(get_coin_history($symbol));
    }

    public function switchCurrency() {
        $code = input('code');
        setcookie("base_currency", $code, time() + 30 * 24 * 60 * 60, config('cookie_path'));
        redirect_back();
    }

    public function downloadCoins() {
        update_coins_lists();
    }

    public function convert() {
        $input  = input('input');
        $from = input('from');
        $to = input('to');
        $type = input('type');
        $currency = find_currency($to);
        $coin = get_coin($from);
        $value = $coin['price'] * $currency['rate'];
        if($type == 'left') {
            $value = $value * $input;
        } else {
            $value =  $input / $value;
        }
        $price = formatNumber($value, config('decimal-point', 3));
        if ($type == 'left') {
            return '<strong>'.$price.'</strong> '.$to;
        } else {
            return '<strong>'.$price.'</strong> '.$from;
        }
    }

    public function widget() {
        Layout::getInstance()->setMainLayout("main::includes/plain");
        $coin = get_coin(input('coin'));
        app()->countryCurrency = input('currency');
        return $this->render(view('main::coin/widget', array('coin' => $coin)));
    }

    public function websiteWidgets() {
        app()->activeMenu = 'tools';
        $this->setTitle(lang('website-widgets'));
        return $this->render(view('main::coin/website-widget'));
    }

    public function calculator() {
        app()->activeMenu = 'tools';
        $this->setTitle(lang('cryptocurrency-converter'));
        return $this->render(view('main::coin/calculator'));
    }
}