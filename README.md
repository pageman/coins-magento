coins-magento
================

Accept Bitcoin on your Magento-powered website with Coins PH. 

Download the plugin here: https://github.com/coinsph/coins-magento/archive/master.zip

Installation
-------

Download the plugin and copy the 'app' folder to the root of your Magento installation.

If you don't have a Coins PH Merchant account, sign up at https://coins.ph/merchants/signup. Coins PH offers daily payouts for merchants in the Philippines. For more infomation on becoming a Coins PH merchant, see https://coins.ph/merchants/.

After installation, open Magento Admin and navigate to System > Configuration then click Payment Methods

Scroll down to 'Coins PH' and follow the instructions. If you can't find 'Coins PH', try clearing your Magento cache.

Fill out the details.
NOTE: Merchant ID and Secret Key will be given, once you have a Merchant account.

Payment Gateway URL
-------
https://dev.coins.ph/pay (Dev Environment)
https://coins.ph/pay


Callback URL
-------
You need to provide you magento redirect_url & callback_url for the plugin to work properly.

callback_url: {base_url}/coins_gateway/callback
Magento will be notified that the order was paid and will create a transaction which has a reference number as its transaction ID.

redirect_url: {base_url}/coins_gateway/redirect/success
This will redirect your users to magento "Thank You" page.