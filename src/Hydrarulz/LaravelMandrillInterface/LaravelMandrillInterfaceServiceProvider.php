<?php namespace Hydrarulz\LaravelMandrillInterface;

use Illuminate\Support\ServiceProvider;
use Config;

class LaravelMandrillInterfaceServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	public function boot()
	{
		$this->publishes([
			__DIR__ . '/../../../config/config.php' => base_path('config/laravel-mandrill-interface.php')
		]);
	}


	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('mandrill-interface', function()
		{
			$token = Config::get('laravel-mandrill-interface.token');

            return new LaravelMandrillInterface($token);
		});

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}

}
