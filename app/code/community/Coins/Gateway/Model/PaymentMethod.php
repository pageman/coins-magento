<?php
 
class Coins_Gateway_Model_PaymentMethod extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'Gateway';
 
    /**
     * Is this payment method a gateway (online auth/charge) ?
     */
    protected $_isGateway               = true;
 
    /**
     * Can authorize online?
     */
    protected $_canAuthorize            = true;
 
    /**
     * Can capture funds online?
     */
    protected $_canCapture              = false;
 
    /**
     * Can capture partial amounts online?
     */
    protected $_canCapturePartial       = false;
 
    /**
     * Can refund online?
     */
    protected $_canRefund               = false;
 
    /**
     * Can void transactions online?
     */
    protected $_canVoid                 = false;
 
    /**
     * Can use this payment method in administration panel?
     */
    protected $_canUseInternal          = true;
 
    /**
     * Can show this payment method as an option on checkout payment page?
     */
    protected $_canUseCheckout          = true;
 
    /**
     * Is this payment method suitable for multi-shipping checkout?
     */
    protected $_canUseForMultishipping  = true;
 
    /**
     * Can save credit card information for future processing?
     */
    protected $_canSaveCc = false;
	
	
    public function authorize(Varien_Object $payment, $amount) 
    {

	  $COINS_HTTP_API = Mage::getStoreConfig('payment/Gateway/pay_url');
      $apiKey = Mage::getStoreConfig('payment/Gateway/api_key');
      $apiSecret = Mage::getStoreConfig('payment/Gateway/api_secret');
	  $apiEmail = Mage::getStoreConfig('payment/Gateway/api_email');

      if($apiKey == null || $apiSecret == null) {
        return null;
      }

      $order = $payment->getOrder();
      $currency = $order->getBaseCurrencyCode();
	  
	  $store = Mage::app()->getStore();
	  $store_name = $store->getName();
	  $store_name = str_replace(" ", "", $store_name);
	  $amount = sprintf("%.2f", $amount);
	  
      $desc = Mage::getStoreConfig('payment/Gateway/api_desc');
      $txn_id = $store_name."_YGGI_".round(microtime(true) * 1000)."_".$order->getId();
      
	  //merchant_id:txnid:amount:currency:description:email:secret_key
	  $digest = $apiKey.":".$txn_id.":".$amount.":".$currency.":".$desc.":".$apiEmail.":".$apiSecret;
	  $digest_tmp= $digest;
	  $digest = sha1($digest);
		
	  //$redirectUrl = $COINS_HTTP_API."?merchantid=".$apiKey."&txnid=".$txn_id."&amount=".$amount."&ccy=".$currency;
	  $redirectUrl = $COINS_HTTP_API."?merchantid=".$apiKey."&txnid=".$txn_id."&amount=".$amount."&ccy=".$currency;
		$redirectUrl = $redirectUrl."&description=".$desc."&email=".$apiEmail."&digest=".$digest;
		$redirectUrl = $redirectUrl."&custom=desktop";
		
      $payment->setIsTransactionPending(true);
      Mage::getSingleton('customer/session')->setRedirectUrl($redirectUrl);
      
      return $this;
    }

    
    public function getOrderPlaceRedirectUrl()
    {
      return Mage::getSingleton('customer/session')->getRedirectUrl();
    }
}
?>
