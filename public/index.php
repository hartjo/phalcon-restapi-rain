<?php

/**
 * Micro Rest
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license none
 * @link https://docs.phalconphp.com/en/latest/reference/tutorial-rest.html
*/

use Phalcon\Mvc\Micro;
use App\Response\JsonResponse;
use \Phalcon\Http\Response;

$dir = dirname(__DIR__);

$appDir = $dir . '/app';
$configPath = $dir . '/config/';

require $appDir . '/resources/response/JsonResponse.php';
require $appDir . '/resources/micro/micro.php';

$autoLoad = $configPath . 'config.autoload.php';

$app = new Application\Micro();

$app->appDir = $appDir;

// Define Autoloads here
$app->setAutoload($autoLoad, $appDir);

// Define the routes here
$app->setRoutes();

$app->before(function () use ($app) {
    return true;
});

$app->after(function () use ($app) {
    $records = $app->getReturnedValue();
	return JsonResponse::make(array($records), 200)->send();
});

$app->options('/([a-z0-9/]+)', function() {
    $response = new Response();
    $response->setHeader('Access-Control-Allow-Origin', '*');
    $response->setHeader('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE');
    $response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');
    return $response;
});

$app->notFound(function () use ($app) {
	JsonResponse::make('Url Not found', 404)->send();
});

$app->handle();
