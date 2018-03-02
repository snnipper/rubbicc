<?php

namespace Rubbicc;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Rubbicc\Gateways\ExpertTextingGateway;
use Rubbicc\Gateways\GatewayInterface;

class Rubbicc
{

	protected $gateway;

	function __construct(GatewayInterface $gateway)
	{
		$this->gateway = $gateway; 
	}

	public function sendMessage($mobile, $message)
	{
        return $this->gateway->sendSms($mobile,$message);
	}

	public function getBalance(){
		return $this->gateway->getBalance();
	}

	public function gateway($name)
	{
		switch($name)
		{
			case 'ExpertTexting':
				$this->gateway = new ExpertTextingGateway();
				break;
		}
		return $this;
	}

}