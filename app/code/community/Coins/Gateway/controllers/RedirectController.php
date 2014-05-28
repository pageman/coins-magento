<?php

class Coins_Gateway_RedirectController extends Mage_Core_Controller_Front_Action
{        

    public function indexAction() {
        echo "test";
    }


    public function successAction() {
        $this->_redirect('checkout/onepage/success', array('_secure'=>true));
    }
}
