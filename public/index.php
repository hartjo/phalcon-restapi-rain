<?php

/**
 * Micro Rest
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
 * @link https://docs.phalconphp.com/en/latest/reference/tutorial-rest.html
*/

$dir = dirname(__DIR__);

$appDir = $dir . '/app';
$configPath = $dir . '/config/';

require $appDir . '/resources/response/JsonResponse.php';
require $appDir . '/resources/micro/micro.php';
require $appDir . '/resources/security/authentication.php';
require $appDir . '/resources/debug/PhpError.php';

register_shutdown_function(['Utilities\Debug\PhpError','runtimeShutdown']);

$autoLoad = $configPath . 'config.autoload.php';

use Phalcon\Mvc\Micro;
use App\Response\JsonResponse;
use App\Security\SecurityApp;

try {

	$app = new Application\Micro();

	set_error_handler(['Utilities\Debug\PhpError','errorHandler']);

	$app->appDir = $appDir;

	// Define Autoloads here
	$app->setAutoload($autoLoad, $appDir);

	// Define the routes here
	$app->setRoutes();

	$app->options('([a-z0-9/]+)', function() {
	    $response = new Response();
	    $response->setHeader('Access-Control-Allow-Origin', '*');
	    $response->setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
	    $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
	    return $response;
	});

	// Before Execute Routes
	$app->before(function () use ($app) {
		// var_dump($app->samplearray());
	    return SecurityApp::sample($app);
	});

	// After Execute Routes
	$app->after(function () use ($app) {
	    $results = $app->getReturnedValue();
	    if(is_array($results)){
	    	return JsonResponse::make(array($results), 200)->send();
	    }

		JsonResponse::make('Return Value is not array', 405)->send();
		die();
		
	});

	// Route NotFound
	$app->notFound(function () use ($app) {
		JsonResponse::make('Url Not found', 404)->send();
	});

	// $app->error( function ($exception) { 
	// 	JsonResponse::make($e->getMessage(), 500)->send();
	// });

	$app->handle();

} catch(\Exception $e) {
	JsonResponse::make($e->getMessage(), 500)->send();
}
