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

$autoLoad = $configPath . 'config.autoload.php';

use Phalcon\Mvc\Micro;
use App\Response\JsonResponse;
use App\Security\SecurityApp;

$app = new Application\Micro();

$app->appDir = $appDir;

// Define Autoloads here
$app->setAutoload($autoLoad, $appDir);

// Define the routes here
$app->setRoutes();

$app->options('/([a-z0-9/]+)', function() {
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
    $records = $app->getReturnedValue();
	return JsonResponse::make(array($records), 200)->send();
});

// Route NotFound
$app->notFound(function () use ($app) {
	JsonResponse::make('Url Not found', 404)->send();
});

$app->handle();
