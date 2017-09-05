# CEX.IO API PHP Library
This library provides a PHP class that can be used to easily interact with the CEX.io API.

## Installation
I recommend you use composer to install this library however it can be downloaded and initialized by hand.

```
composer require shaunr/cexio
```

## Usage Example

Currently this library only supports the REST API provided by CEX.io. I doubt i'll have support for the FIX API but I do plan to add support for WebSocket in the future. 

### REST
```php
<?php

use ShaunR\Cexio\Rest as Cexio;

$cexio = new Cexio([
	'api-endpoint' => 'https://cex.io/api',
	'api-userid' => 'User ID',
	'api-key' => 'API KEY',
	'api-secret' => 'API SECRET'
]);

$balances = $cexio->balance();
foreach ($balances as $symbol => $balance) {
	echo $symbol . " Wallet has " . $balance->available . " available\n";
}
```
## Public Functions
Public functions **do not** require any authentication information and are open to the world. If your API UserId, API Key, or API Secret are passed when initializing this library they **will not** be sent to CEX.IO.

https://cex.io/rest-api#currency-limits
```php
$cexio->currencyLimits();
```
https://cex.io/rest-api#ticker
```php
$cexio->ticker('BTC', 'USD');
```
https://cex.io/rest-api#tickers-all
```php
$cexio->tickers('USD', 'EUR', 'RUB', 'BTC');
```
https://cex.io/rest-api#lprice
```php
$cexio->lastPrice('BTC', 'USD');
```
https://cex.io/rest-api#lprice-all
```php
$cexio->lastPrices('BTC', 'USD', 'LTC');
```
https://cex.io/rest-api#converter
```php
$cexio->convert('BTC', 'USD', [ 'amnt' => 2.5 ]);
```
https://cex.io/rest-api#chart
```php
$cexio->priceStats('BTC', 'USD', [
	'lastHours' => 24, 
	'maxRespArrSize' = 100
]);
```
https://cex.io/rest-api#minute-chart
```php
$cexio->ohlcv('20160228', 'BTC', 'USD');
```
https://cex.io/rest-api#orderbook
```php
$cexio->orderBook('BTC', 'USD', [
	'depth' => 1
]);
```
https://cex.io/rest-api#trade-history
```php
$cexio->tradeHistory('BTC', 'USD', [
	'since' => 1
]);
```
## Private Functions
Private functions **do require** authentication and are restricted to the IP Address's you set under the API section of CEX.IO. You will need your API User ID, API Key, and API Secret when initializing this library. They will always be sent to CEX.IO via a POST request. Your authentication information can be created and found on the CEX.IO website under the API section.

https://cex.io/rest-api#balance
```php
$cexio->balance();
```
https://cex.io/rest-api#open-orders
```php
$cexio->openOrders('BTC', 'USD');
```
https://cex.io/rest-api#active-order-status
```php
$cexio->activeOrdersStatus([
	'orders_list' => [ 8550492, 8550495, 8550497 ]
]);
```
https://cex.io/rest-api#archived-orders
```php
$cexio->archivedOrders('BTC', 'USD', [
	'limit' => 100,
	'dateTo' => 1504303313,
	'dateFrom' => 1504302313,
	'lastTxDateTo' => 1504303313,
	'lastTxDateFrom' => 1504302313,
	'status' => 'cd'
]);
```
https://cex.io/rest-api#cancel-order
```php
$cexio->cancelOrder([
	'id' => 1
]);
```
https://cex.io/rest-api#cancel-all
```php
$cexio->cancelOrders('BTC', 'USD');
```
https://cex.io/rest-api#place-order
```php
$cexio->placeOrder('BTC', 'USD', [
	'type' => 'buy',
	'amount' => '1.1',
	'price' => '1.00'
]);
```
https://cex.io/rest-api#place-instant-order
```php
$cexio->placeOrder('BTC', 'USD', [
	'type' => 'buy',
	'amount' => '1.1',
	'order_type' => 'market'
]);
```
https://cex.io/rest-api#get-order-details
```php
$cexio->getOrder([ 'id' => 1 ]);
```
https://cex.io/rest-api#get-order-tx
```php
$cexio->getOrderTx([ 'id' => 1 ]);
```
https://cex.io/rest-api#get-address
```php
$cexio->getAddress([ 'currency' => 'BTC' ]);
```
https://cex.io/rest-api#get-fee
```php
$cexio->getMyFee();
```
https://cex.io/rest-api#cancel-replace
```php
$cexio->cancelReplaceOrder('BTC', 'USD', [
	'type' => 'buy',
	'amount' => 1,
	'price' => 1.50,
	'order_id' => 123456
]);
```
https://cex.io/rest-api#open-position
```php
$cexio->openPosition('BTC', 'USD', [
	'amount' => '1',
	'symbol' => 'BTC',
	'leverage' => '2',
	'ptype' => 'long',
	'anySlippage' => 'true',
	'eoprice' => '650.3232',
	'stopLossPrice' => '600.3232'
]);
```
https://cex.io/rest-api#open-positions
```php
$cexio->openPositions('BTC', 'USD');
```
https://cex.io/rest-api#close-position
```php
$cexio->closePosition('BTC', 'USD', [
	'id' => 104034
]);
```
## Donate
If you found this useful and want to show your appreciation you donations are always appreciated!

 - Bitcoin (BTC): 1M5aBCJ217LMinFCTRx1p7JQMgYCsTsJ2F
 - Ethereum (ETH): 0xe26be81d7933c86c0cf08aa3ccf6b4874bfce830
 - BitcoinCash (BCC/BCH): 16bJ91NZutTmoxaiQXgz7voWVhRaNoFTuY

Thank you!
