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

require $appDir . '/resources/micro/micro.php';
require $appDir . '/resources/response/JsonResponse.php';
require $appDir . '/resources/security/SecurityApp.php';

$autoLoad = $configPath . 'config.autoload.php';
$env = $configPath . 'config.env.php';

use Phalcon\Mvc\Micro;
use App\Response\JsonResponse;
use App\Security\SecurityApp;

try {

	$app = new Application\Micro();

	$app->appDir = $appDir;

	// Define Autoloads here
	$app->setAutoload($autoLoad, $appDir);

	// Define Env and Database connections
	$app->setConfig($env);

	// Define the routes here
	$app->setRoutes($app->request->getURI());

	$app->options('/([a-z0-9/]+)', function() {
	    $response = new Response();
	    $response->setHeader('Access-Control-Allow-Origin', '*');
	    $response->setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
	    $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
	    return $response;
	});

	// Before Execute Routes
	$app->before(function () use ($app) {

		// authentication logic here
	    return SecurityApp::jwtAuthentication($app);
	});

	// After Execute Routes
	$app->after(function () use ($app) {

	    $results = $app->getReturnedValue();
	    if(is_array($results)){
	    	JsonResponse::make(array($results), 200)->send();
	    	return;
	    }

		JsonResponse::make('Return Value is not an array', 405)->send();
		return; 
		
	});

	// Route NotFound
	$app->notFound(function () use ($app) {
		JsonResponse::make('Url Not found', 404)->send();
		return;
	});

	$app->handle();

} catch(Exception $e) {
	JsonResponse::make($e->getMessage(), 500)->send();
	return;
}
