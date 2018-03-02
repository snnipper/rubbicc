<?php

namespace Rubbicc;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Rubbicc\Rubbicc;

class RubbiccServiceProvider extends ServiceProvider
{

	protected $configName = 'rubbick';

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../config/' . $this->configName . '.php';
		$this->publishes([
			$configPath => config_path($this->configName . '.php')
		], 'config');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 **/
	public function register()
	{
		$gateway = Config::get('rubbick.gateway');
		$this->app->bind('rubbicc', 'Rubbicc\Rubbicc'); 
		$this->app->bind('Rubbicc\Gateways\GatewayInterface', 'Rubbicc\Gateways\\'.$gateway.'Gateway');
	}

}