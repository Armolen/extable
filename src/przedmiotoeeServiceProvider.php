<?php namespace ciscmodule\extable;

use Illuminate\Support\ServiceProvider;

class przedmiotoeeServiceProvider extends ServiceProvider
{
    
    
	/**
	 * Rejestracja komend dla artisana
	 */
	protected $commands = [
        //    \ciscmodule\oeeprzedmont\Commands\Importdanychzip::class //dla systemu importu
	];    
    
        protected $providers = [
            \ciscmodule\extable\Providers\RouteServiceProvider::class,
        ];

        
	/**
	 * Register providers
	 */
	protected function registerProviders()
	{

		foreach ($this->providers as $providerClass)
		{
			$provider = app($providerClass, [app()]);
			$provider->register();
		}
	}
        
	public function register()
	{
            oeeprzedmont::instance();
            $this->registerProviders();
            $this->registerCommands();
	}
        
	/**
	 * Rejestracja komend dla artisana
	 */
	protected function registerCommands()
	{
		foreach ($this->commands as $command)
		{
			$this->commands($command);
		}
	}        

	public function boot()
	{
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'getemplate');
//                dd(__DIR__ . '/../resources/views/default');
		$this->publishes([
			__DIR__ . '/public/' => public_path('packages/getemplate/'),
		], 'asset-modoee'); //assets-
		
		if(method_exists($this, "loadMigrationsFrom"))
                $this->loadMigrationsFrom(__DIR__.'/database/migrations');

	}

}