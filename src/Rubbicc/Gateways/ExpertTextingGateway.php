<?php

namespace Rubbicc\Gateways;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class ExpertTextingGateway implements GatewayInterface
{

	private $URL_SENDER   = "https://www.experttexting.com/ExptRestApi/sms/json/Message/Send";
	private $URL_BALANCE  = "https://www.experttexting.com/ExptRestApi/sms/json/Account/Balance";
	private $config       = array();
	private $request      = '';
	private $response     = '';
	private $country_code = null;

	function __construct()
	{
		$this->config       = Config::get('rubbick.ExpertTexting');
		$this->country_code = Config::get('rubbick.country_code');
	}

	public function getParams()
	{
		foreach ($this->config as $key => $value){
			$this->request .= $key."=".urlencode($value);
			$this->request.= "&";
		}
		$this->request = substr($this->request, 0, strlen($this->request)-1);
		return $this->request;
	}

	public function postParams($mobile, $message)
	{
		$params         = $this->config;
		$params['to']   = $mobile;
		$params['text'] = $message;
		return [
			RequestOptions::JSON => $params
		];
	}

	public function sendSms($mobile, $message)
	{
		$mobile = $this->addCountryCode($mobile);
		try{
			$client = new Client();
			$this->response = $client
				->post($this->URL_SENDER, $this->postParams($mobile, $message))
				->getBody()
				->getContents();
		}catch (RequestException $e) {
			if ($e->hasResponse()) {
				$this->response = $e->getResponseBodySummary($e->getResponse());
			}
		}
		Log::info('Experttexting Gateway Response Send: '.$this->response);
		return $this->response;
	}

	public function getBalance()
	{
		try{
			$client = new Client();
			$this->response = $client
				->get($this->URL_BALANCE."?".$this->getParams())
				->getBody()
				->getContents();
		}catch (RequestException $e) {
			if ($e->hasResponse()) {
				$this->response = $e->getResponseBodySummary($e->getResponse());
			}
		}
		Log::info('Experttexting Gateway Response balance: '.$this->response);
		return $this->response;
	}

	public function addCountryCode($mobile) {
		return $this->country_code.$mobile;
	}

}