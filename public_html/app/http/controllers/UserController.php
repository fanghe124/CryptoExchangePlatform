<?php
class UserController extends Controller {
    public function settings() {
        $type = input('type', 'profile');
        $this->setTitle(lang('edit-profile'));
        $message = null;
        $errorMessage = null;
        if (request_is_post()) {

            $email = input('email');


            if ($email != get_user()['email']) {
                if (check_email($email, get_userid())) {
                    $email = get_user()['email'];
                    $errorMessage = lang('email-already-exist');
                }
            }

            $old = input('old');
            $new = input('new');
            $confirm = input('confirm');
            if($old and $new and $confirm) {
                if (!hash_check($old,get_user()['password'])) {
                    $errorMessage = lang('old-password-wrong');
                } else {
                    if ($new != $confirm) {
                        $errorMessage = lang('new-password-not-match');
                    } else{
                        update_user_password($new);
                        $message = lang('password-changed-success');
                    }
                }
            }
            if ($errorMessage) $message = lang('profile-details-updated-success');
            update_user_details($email);
        }
        $content = view('main::user/settings', array('message' => $message, 'error' => $errorMessage));
        return $this->render($content);
    }



    public function search() {
        $term = input('term');
        $coins = search_coins($term);
        return view('main::search/result', array('coins' => $coins));
    }

    public function watchlist() {
        $this->setTitle(lang('watchlist'));
        app()->activeMenu = 'watchlist';
        return $this->render(view('main::watchlist/index'));
    }

    public function watchlistAdd() {
        $coin = input('coin');
        return add_watchlist($coin);
    }

    public function alerts() {
        app()->activeMenu = 'alerts';
        $this->setTitle(lang('price-alerts'));

        if(request_is_post() and input('price')) {
            add_alert(input('coin'), input('type'), input('price'));
            return true;
        }

        if($delete = input('action')) {
            delete_alert(input('id'));
            redirect(url('alerts'));
        }

        return $this->render(view('main::alerts/index'));
    }

   public function pricing() {
       $this->setTitle(lang('premium-member'));
       return $this->render(view('main::user/pricing'));
   }

    public function payStripe() {
        include(path('app/vendor/omnipay/vendor/autoload.php'));
        $gateway = Omnipay\Omnipay::create('Stripe');
        $gateway->setApiKey(config('stripe-secret-key'));

        //$formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
        $price = number_format(input('price'),2);
        $response = $gateway->purchase(array('amount' => $price, 'currency' => config('subscription-currency','USD'), 'token' => input('token')))->send();


        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            //$response->redirect();
        } elseif ($response->isSuccessful()) {
            // payment was successful: update database
            activate_user_plan(input('plan'), input('type'));
            return json_encode(array(
                'status' => 1,
                'message' => lang('thanks-pay-note')
            ));
        } else {
            // payment failed: display message to customer

            return json_encode(array(
                'status' => 0,
                'message' => $response->getMessage()
            ));
        }
    }

    public function payPaypal() {
        include(path('app/vendor/omnipay/vendor/autoload.php'));
        $gateway = Omnipay\Omnipay::create('PayPal_Express');
        $gateway->setUsername(config('paypal-username'));
        $gateway->setPassword(config('paypal-password'));
        $gateway->setSignature(config('paypal-signature'));
        if (config('paypal-test-mode', true)) {
            $gateway->setTestMode(true);
        }

        $price = number_format(input('price'),2);
        session_put('pay-price', $price);
        session_put('pay-plan', input('plan'));
        session_put('pay-type', input('type'));
        $params = array(
            'cancelUrl' => url('pay/paypal//cancel'),
            'returnUrl' => url('pay/paypal//success'),
            'amount' => $price,
            'currency' => config('subscription-currency','USD'),
        );

        //Session::put('params', $params);
        //Session::save();
        $items = [
            [
                'name' => "Subscription Plan",
                'quantity' => 1,
                'price' => $price
            ]
        ];

        $response = $gateway->purchase($params)->setItems($items)->send();

        if ($response->isRedirect()) {
            // redirect to offsite payment gateway
            $response->redirect();
        } else {
            // p ayment failed: display message to customer
            redirect(url('pricing'));
        }
    }

    public function paypalCancel() {
        redirect(url('pricing'));
    }

    public function paypalSuccess() {
        include(path('app/vendor/omnipay/vendor/autoload.php'));
        $gateway = Omnipay\Omnipay::create('PayPal_Express');
        $gateway->setUsername(config('paypal-username'));
        $gateway->setPassword(config('paypal-password'));
        $gateway->setSignature(config('paypal-signature'));
        if (config('paypal-test-mode', true)) {
            $gateway->setTestMode(true);
        }

        $params = array(
            'cancelUrl' => url('pay/paypal//cancel'),
            'returnUrl' => url('pay/paypal//success'),
            'amount' => session_get('pay-price'),
            'currency' => config('subscription-currency','USD'),
        );

        $response = $gateway->completePurchase($params)->send();
        $paypalResponse = $response->getData(); // this is the raw response objec

        if (isset($paypalResponse['PAYMENTINFO_0_ACK']) and
        $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success'
        ) {
            // All set do some work here for your business logic
            activate_user_plan(session_get('pay-plan'), session_get('pay-type'));
            redirect(url('settings'));
        }

    }

    public function news() {
        $news = request_url("https://min-api.cryptocompare.com/data/news/");
        if ($news) {
            return view('main::home/news', array('news' => $news));
        }
    }
}
