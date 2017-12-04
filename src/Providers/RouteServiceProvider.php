<?php namespace ciscmodule\extable\Providers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;
use Route;

class RouteServiceProvider extends ServiceProvider
{

	public function register()
	{

		Route::group([
			'prefix'    => config('modoee.modprefix.extable','extable'),
			'namespace' => 'ciscmodule\extable\Http\Controllers',
		], function ()
		{
			Route::group([
				'middleware' => config('modoee.middleware','web'),
			], function ()
			{
				$file = config('modoee.bootstrapDirectory') . '/routes.php';
				if (file_exists($file))
				{
					require $file;
				}
			});
			$routesFile = __DIR__ . '/../Http/routes.php';
			if (file_exists($routesFile))
			{
				require $routesFile;
			}
		});
	}

	public static function registerRoutes($callback)
	{
		Route::group([
			'prefix'     => config('admin.prefix'),
			'middleware' => config('admin.middleware'),
		], $callback);
	}


}