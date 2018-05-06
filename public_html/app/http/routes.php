<?php
Router::addFilter('home', function() {

    return true;
});
Router::addFilter('auth', function() {
    if (!is_loggedin()) {
        if (is_ajax()) exit('login-is-needed');
        return redirect(url('?login=true'));
    }
    return true;
});



Router::addFilter('admincp', function() {
    if (!is_loggedin()) {
        if (is_ajax()) exit(json_encode(array('status' => 0, 'message' => 'Please login')));
        return redirect(url('?login=true'));
    }
    if (!is_admin()) return redirect(url());
    Layout::getInstance()->pageType = "backend";
    return true;
});

Router::get("/", array( 'uses' => 'HomeController@index'))->addFilter('home');

Router::get("trending", array( 'uses' => 'HomeController@home'))->addFilter('home');
Router::get("latestnews", array( 'uses' => 'HomeController@home'))->addFilter('home');

Router::get("gainers", array( 'uses' => 'HomeController@index'))->addFilter('home');
Router::get("losers", array( 'uses' => 'HomeController@index'))->addFilter('home');
Router::get("terms", array( 'uses' => 'HomeController@info'));
Router::get("privacy", array( 'uses' => 'HomeController@info'));
Router::get("about", array( 'uses' => 'HomeController@info'));


Router::get("signin", array( 'uses' => 'HomeController@logreg'))->addFilter('home');
Router::get("register", array( 'uses' => 'HomeController@logreg'))->addFilter('home');


Router::post("signup", array( 'uses' => 'HomeController@signup'));

Router::get("translator", array( 'uses' => 'HomeController@translator'));
Router::post("login", array( 'uses' => 'HomeController@login'));
Router::any("forgot-password", array( 'uses' => 'HomeController@forgot'));
Router::any("reset/password", array( 'uses' => 'HomeController@reset'));

Router::any("activate/success", array( 'uses' => 'HomeController@activateSuccess'));
Router::any("activate/account", array( 'uses' => 'HomeController@activate'));

Router::any("sitemap", array( 'uses' => 'HomeController@sitemap'));
Router::any("sitemap/txt", array( 'uses' => 'HomeController@sitemap'));
Router::any("sitemap/xml", array( 'uses' => 'HomeController@sitemap'));

Router::get("logout", array( 'uses' => 'HomeController@logout'));

Router::any("set/language", array( 'uses' => 'HomeController@setLanguage'));
Router::any("turn/light", array( 'uses' => 'HomeController@turnLight'));

Router::any("page/{slug}", array( 'uses' => 'HomeController@pages'))->where(array('slug' => '[a-zA-Z0-9\-\_]+'));


Router::any("social/auth/{id}", array( 'uses' => 'SocialController@index'))->where(array('id' => '[a-zA-Z0-9\-\_]+'));



Router::any("settings", array( 'uses' => 'UserController@settings'))->addFilter('auth');
Router::any("pricing", array( 'uses' => 'UserController@pricing'))->addFilter('auth');
Router::any("pay/stripe", array( 'uses' => 'UserController@payStripe'))->addFilter('auth');
Router::any("pay/paypal", array( 'uses' => 'UserController@payPaypal'))->addFilter('auth');
Router::any("pay/paypal/cancel", array( 'uses' => 'UserController@paypalCancel'))->addFilter('auth');
Router::any("pay/paypal/success", array( 'uses' => 'UserController@paypalSuccess'))->addFilter('auth');
Router::any("watchlist", array( 'uses' => 'UserController@watchlist'))->addFilter('auth');
Router::any("watchlist/add", array( 'uses' => 'UserController@watchlistAdd'))->addFilter('auth');

Router::any("alerts", array( 'uses' => 'UserController@alerts'))->addFilter('auth');
Router::any("search", array( 'uses' => 'UserController@search'));

Router::any("news", array( 'uses' => 'UserController@news'));
Router::any("roi", array( 'uses' => 'RoiController@index'));


Router::get('admincp', array('uses' => 'AdminController@index' ))->addFilter('admincp');
Router::any('admincp/settings', array('uses' => 'AdminController@settings' ))->addFilter('admincp');
Router::any('admincp/system/update', array('uses' => 'AdminController@updateSystem' ))->addFilter('admincp');

Router::any('admincp/appearance', array('uses' => 'AdminController@appearance' ))->addFilter('admincp');
Router::any('admincp/users', array('uses' => 'AdminController@users' ))->addFilter('admincp');
Router::any('admincp/user/edit', array('uses' => 'AdminController@editUser' ))->addFilter('admincp');
Router::any('admincp/coins', array('uses' => 'AdminController@coins' ))->addFilter('admincp');
Router::any('admincp/adverts', array('uses' => 'AdminController@adverts' ))->addFilter('admincp');
Router::any('admincp/pages', array('uses' => 'AdminController@pages' ))->addFilter('admincp');
Router::any('admincp/currencies', array('uses' => 'AdminController@currencies' ))->addFilter('admincp');
Router::any('admincp/menu', array('uses' => 'AdminController@menu' ))->addFilter('admincp');
Router::any('admincp/module', array('uses' => 'AdminController@module' ))->addFilter('admincp');
Router::any("cron/run", array( 'uses' => 'CronController@run'));

Router::any("coin/{username}", array( 'uses' => 'CoinController@index'))->where(array('username' => '[a-zA-Z0-9\-\_]+'));

Router::any("widget", array( 'uses' => 'CoinController@widget'));
Router::any("website-widgets", array( 'uses' => 'CoinController@websiteWidgets'));
Router::any("calculator", array( 'uses' => 'CoinController@calculator'));
Router::any("convert", array( 'uses' => 'CoinController@convert'));

Router::any("blog", array( 'uses' => 'BlogController@index'));
Router::any("blog/{id}/{slug}", array( 'uses' => 'BlogController@page'))->where(array('slug' => '[a-zA-Z0-9\-\_]+', 'id' => '[0-9]+'));

Router::any("portfolio", array( 'uses' => 'PortfolioController@index'))->addFilter('auth');
Router::any("portfolio/coin/save", array( 'uses' => 'PortfolioController@saveCoin'))->addFilter('auth');
Router::any("portfolio/coin/remove", array( 'uses' => 'PortfolioController@removeCoin'))->addFilter('auth');


Router::any("load/history", array( 'uses' => 'CoinController@getHistory'));
Router::any("currency/switch", array( 'uses' => 'CoinController@switchCurrency'));
