<?php

namespace ShaunR\Cexio;

use \Curl\Curl;
use \Exception;

class Rest
{
	protected $curl;

	protected $settings = [
		'api-endpoint' => 'https://cex.io/api',
		'api-userid' => '',
		'api-key' => '',
		'api-secret' => '',
		'debug' => false
	];

	function __construct(array $settings = [])
	{
		foreach ($settings as $settingKey => $settingValue) {
			if (array_key_exists($settingKey, $this->settings)) {
				$this->settings[$settingKey] = $settingValue;
				unset($settings[$settingKey]);
			}
		}

		if (count($settings) > 0) {
			$exceptionMessage = '';
			foreach ($settings as $settingKey => $settingValue) {
				$exceptionMessage .= "Unknown setting " . $settingKey . "\n";
			}
			throw new exception ($exceptionMessage);
		}

		$this->curl = new Curl();
		$this->curl->setHeader("Content-Type", "application/json");
	}

	public function currencyLimits()
	{
		$result = $this->request('/currency_limits/', [], false);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function ticker(string $symbol1 = '', string $symbol2 = '')
	{
		return $this->request('/ticker/' . $symbol1 . '/' . $symbol2, [], false);
	}

	public function tickers(...$symbols)
	{
		$result = $this->request('/tickers/' . implode('/', $symbols), [], false);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function lastPrice(string $symbol1 = '', string $symbol2 = '')
	{
		return $this->request('/last_price/' . $symbol1 . '/' . $symbol2, [], false);
	}

	public function lastPrices(...$symbols)
	{
		$result = $this->request('/last_prices/' . implode('/', $symbols), [], false);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responsed with a status of error');
		}
		return $result->data;
	}

	public function convert(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		return $this->request('/convert/' . $symbol1 . '/' . $symbol2, $params, false);
	}

	public function priceStats(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		return $this->request('/price_stats/' . $symbol1 . '/' . $symbol2, $params, false);
	}

	public function ohlcv(string $date = '', string $symbol1 = '', string $symbol2 = '')
	{
		return $this->request('/ohlcv/hd/' . $date . '/' . $symbol1 . '/' . $symbol2, [], false);
		return $result;
	}

	public function orderBook(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		$requestUrl = '/order_book/' . $symbol1 . '/' . $symbol2 . '/';
		if (count($params) > 1) {
			$requestUrl .= '?' . http_build_query($params);
		}
		return $this->request($requestUrl, [], false);
	}

	public function tradeHistory(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		$requestUrl = '/trade_history/' . $symbol1 . '/' . $symbol2 . '/';
		if (count($since) > 0) {
			$requestUrl .= '?' . http_build_query($params);
		}
		return $this->request($requestUrl, [], false);
	}

	public function balance()
	{
		return $this->request('/balance/', [], true);
	}

	public function openOrders(string $symbol1 = '', string $symbol2 = '')
	{
		$requestUrl = '/open_orders/';
		if ($symbol1 != '') {
			$requestUrl .= $symbol1 . '/';
		}
		if ($symbol2 != '') {
			$requestUrl .= $symbol2 . '/';
		}
		return $this->request($requestUrl, [], true);
	}

	public function activeOrdersStatus(array $params = [])
	{
		$result = $this->request('/active_orders_status/', $params, true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function archivedOrders(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		return $this->request('/archived_orders/' . $symbol1 . '/' . $symbol2, $params, true);
	}

	public function cancelOrder(array $params = [])
	{
		return $this->request('/cancel_order/', $params, true);
	}

	public function cancelOrders(string $symbol1 = '', string $symbol2 = '')
	{
		$result = $this->request('/cancel_orders/' . $symbol1 . '/' . $symbol2, [], true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function placeOrder(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		return $this->request('/place_order/' . $symbol1 . '/' . $symbol2, $params, true);
	}

	/* returns NULL if order does not exist */
	public function getOrder(array $params = [])
	{
		return $this->request('/get_order/', $params, true);
	}

	public function getOrderTx(array $params = [])
	{
		$result = $this->request('/get_order_tx/', $params, true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function getAddress(array $params = [])
	{
		$result = $this->request('/get_address/', $params, true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function getMyFee()
	{
		$result = $this->request('/get_myfee/', [], true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}
	
	public function cancelReplaceOrder(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		return $this->request('/cancel_replace_order/' . $symbol1 . '/' . $symbol2, $params, true);
	}

	public function openPosition(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		$result = $this->request('/open_position/' . $symbol1 . '/' . $symbol2, $params, true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function openPositions(string $symbol1 = '', string $symbol2 = '')
	{
		$result = $this->request('/open_positions/' . $symbol1 . '/' . $symbol2, [], true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	public function closePosition(string $symbol1 = '', string $symbol2 = '', array $params = [])
	{
		$result = $this->request('/open_position/' . $symbol1 . '/' . $symbol2, $params, true);
		if ($result->ok != "ok") {
			throw new exception('CEXIO responded with a status of error');
		}
		return $result->data;
	}

	private function request(string $url = '', array $post = [], bool $authenticate = false)
	{
		if ($authenticate === true) {
			$nonce = str_replace('.', '', microtime(true));
			$message = $nonce . $this->settings['api-userid'] . $this->settings['api-key'];
			$signature = strtoupper(hash_hmac('sha256', $message, $this->settings['api-secret']));

			$post['key'] = $this->settings['api-key'];
			$post['signature'] = $signature;
			$post['nonce'] = $nonce;
		}
			
		if (is_array($post) && count($post) > 0) {
			$this->curl->post($this->settings['api-endpoint'] . $url, $post);
		} else {
			$this->curl->get($this->settings['api-endpoint'] . $url);
		}

		if ($this->curl->error) {
			throw new exception ("Curl Error: " . $this->curl->errorMessage . " (" . $this->curl->errorCode . ")");
		}


		$jsonObject = json_decode($this->curl->response, false);
		/* Some responses will return null if no data is found. Because of this we also check json_last_error
		   to see if a real erorr exists before throwing a exceptin. */
		if (is_null($jsonObject) && json_last_error() > 0) {
			throw new exception("Failed to decode JSON response: " . json_last_error());
		}
		unset ($jsonObject->timestamp, $jsonObject->username);

		return $jsonObject;
	}
}
