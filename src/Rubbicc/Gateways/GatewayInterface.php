<?php

namespace Rubbicc\Gateways;

interface GatewayInterface
{
	public function getParams();
	public function postParams($mobile, $message);
	public function sendSms($mobile, $message);
	public function getBalance();
	public function addCountryCode($mobile);
}