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
require $appDir . '/resources/errors/HTTPException.php';
require $dir . '/vendor/autoload.php';

$autoLoad = $configPath . 'config.autoload.php';
$env = $configPath . 'config.env.php';

use Phalcon\Mvc\Micro;
use App\Response\JsonResponse;
use App\Security\SecurityApp;
use App\Exceptions\HTTPException;

try {

	$app = new Application\Micro();

	// php error parse handler
	function error_alert() 
	{ 
		if(is_null($e = error_get_last()) === false) 
		{ 
			// var_dump($e);
			if($e['file'] != 'Unknown' && $e['line'] != 0){
				HTTPException::returnParseError($e);
			}
		} 
	} 
	error_reporting(0);
	register_shutdown_function('error_alert'); 

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
	    $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With, content-type, Authorization');
	    return $response;
	});

	/**
	 * Before Execute Routes
	 */
	$app->before(function () use ($app) {
		// authentication logic here
	    return SecurityApp::jwtAuthentication($app);
	});

	/**
	 * After Execute Routes
	 */
	$app->after(function () use ($app) {

	    $results = $app->getReturnedValue();

	    if(empty($results)){
	    	throw new HTTPException(
	    		'No available response to your request.',
	    		412,
	    		array(
	    			'dev' => 'Returned empty set',
	    			'internalCode' => 'ER412',
	    			'more' => 'No Return value'
	    			)
	    		);
	    }

	    if(is_array($results)){
	    	JsonResponse::make(array($results), 200)->send();
	    	return;
	    }

	    throw new HTTPException(
	    	'Could not return results in specified format',
	    	403,
	    	array(
	    		'dev' => 'Return value must be an array.',
	    		'internalCode' => 'AR403',
	    		'more' => 'your return value must be an array'
	    		)
	    	);
		
	});

	/**
	 * Route NotFound
	 */
	$app->notFound(function () use ($app) {

		throw new HTTPException(
			'There was a problem understanding the data sent to the server by the application.',
			404,
			array(
				'dev' => 'Api url not found '. $app->request->getURI().'',
				'internalCode' => 'R404',
				'more' => 'Please Check your request Url'
				)
			);

	});

	$app->handle();

} catch(Exception $e) {
	
	JsonResponse::error($e, $e->getCode())->send();
	return;

}
