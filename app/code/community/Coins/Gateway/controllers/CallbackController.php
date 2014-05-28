<?php

class Coins_Gateway_CallbackController extends Mage_Core_Controller_Front_Action
{        

    public function indexAction() {
		$txnid = $_POST['txnid'];
		$refno = $_POST['refno'];
		$status = $_POST['status'];

		$message = $_POST['message'];
		$amount = $_POST['amount'];
		$digest = $_POST['digest'];
			
        $apiSecret = Mage::getStoreConfig('payment/Gateway/api_secret');
		//txnid:refno:amount:status:message:secret_key
		$callback_digest = $txnid.":".$refno.":".$amount.":".$status.":".$message.":".$apiSecret;
		$callback_digest = sha1($callback_digest);

		$data = explode("_", $txnid);
		$orderId = $data[count($data)-1];
					
		if ($callback_digest == $digest) {

	      	$order = Mage::getModel('sales/order')->load($orderId);
			if ($order == 0) return;
	        // The callback is legitimate. Update the order's status in the database.
			if ($status == 'S') {
		        $payment = $order->getPayment();
		        $payment->setTransactionId($refno)
		          ->setPreparedMessage("Paid with Bitcoins via Coins Ref #: $refno.")
		          ->setShouldCloseParentTransaction(true)
		          ->setIsTransactionClosed(0);
        
				$payment->registerCaptureNotification($amount);
		        $order->save();
			}
			echo "{success:true}";
		} else {
			echo "{success:false}";
		}
    }

}
