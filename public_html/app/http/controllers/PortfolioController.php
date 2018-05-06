<?php
class PortfolioController extends Controller {

    public function index() {
        $this->setTitle(lang('portfolio'));
        app()->activeMenu = 'portfolio';
        return $this->render(view('main::portfolio/page'));
    }

    public function saveCoin() {
        $id = input('id');
        $purchase = input('purchase');
        $sold = config('base_currency', 'USD');
        $amount = input('amount');
        $rate = input('rate');
        $date = input('time');
        return save_portfolio_coin($purchase,$sold,$amount,$rate,$date);
    }
	
	
	public function removeCoin() {
		
        $ids = input('portfolioids');

        return remove_portfolio_coin($ids);
    }
	
	
	
}