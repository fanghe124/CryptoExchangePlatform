<?php
class CronController extends Controller {
    public function run() {

        set_time_limit(36000);
        update_global_data();
        update_rates_data();
        update_coins_data();
        update_coin_alerts();
        if (input('install')) return redirect(url());
        exit('done');
    }
}