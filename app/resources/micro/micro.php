<?php

/**
 * Micro Rest Application
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
*/

namespace Application;

use Phalcon\Loader,
	Phalcon\Exception,
	Phalcon\Mvc\Micro\Collection,
	Phalcon\Http\Request,
	Phalcon\DI\FactoryDefault,
	App\Response\JsonResponse;

class Micro extends \Phalcon\Mvc\Micro {

	public $appDir;

	protected $_routeAllowed;

	// constuct
	public function __construct() {
		$this->_routeAllowed = array();
	}

	public function routeAllowed(){
		return $this->_routeAllowed;
	}

	public function setConfig($env) {

		// define Dependency Injector
		$di = new FactoryDefault();

		// Set request di
		$di->set("request", new Request());

		// Set Envenronmental Variables
		$di->set('env', new \Phalcon\Config(require $env));

		// Set database for custom PDO
		$di->set('db', function() use ($di) {

			$type = strtolower($di->get('env')->database->adapter);
			$creds = array(
				'host' => $di->get('env')->database->host,
				'username' => $di->get('env')->database->username,
				'password' => $di->get('env')->database->password,
				'dbname' => $di->get('env')->database->name
			);

			if ($type == 'mysql') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Mysql($creds);
			} else if ($type == 'postgres') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Postgresql($creds);
			} else if ($type == 'sqlite') {
				$connection =  new \Phalcon\Db\Adapter\Pdo\Sqlite($creds);
			} else {
				throw new Exception('Bad Database Adapter');
			}

			return $connection;
		});
		
	}

	// set autoload components
	public function setAutoload($file, $appDir) {
		
		if (!file_exists($file)) {
			JsonResponse::make('Unable to load autoloader file', 500)->send();
		}

		$namespaces = include $file;
		$loader = new Loader();
		$loader->registerNamespaces($namespaces)->register();

	}

	//set routes collection
	public function setRoutes($req) {

		$reqUri = $req;

		$getreqPrefix = explode('/', $reqUri);

		$collections = array();

		$collectionFiles = scandir($this->appDir . '/resources/routes');

		foreach($collectionFiles as $collectionFile){
			$pathinfo = pathinfo($collectionFile);

			if($pathinfo['extension'] === 'php'){
				
				$getcollection = include($this->appDir.'/resources/routes/'.$collectionFile);
				$prefixrplc =  str_replace('/', '',$getcollection['prefix']);

				if($prefixrplc == $getreqPrefix[1]){
					$collections[] = $this->buildcollection($getcollection);
				}

			}
		}

		foreach($collections as $collection){
			$this->mount($collection);
		}
	
	}
	//end of setRoutes

	//build route collection
	private function buildcollection($route){

		$cltn = new Collection();

		$cltn->setPrefix($route['prefix'])
		->setHandler($route['handler'])
		->setLazy($route['lazy']);

		foreach($route['collection'] as $obj){

			if($obj['authentication']===false){

				$method = strtolower($obj['method']);

				if (!isset($this->_routeAllowed[$method])) {
					$this->_routeAllowed[$method] = array();
				}
				$this->_routeAllowed[$method][] = $route['prefix'].$obj['route'];

			}

			$cltn->{$obj['method']}($obj['route'], $obj['function']);

		}

		return $cltn;

	}
	//end of buildcollection


}
// end of class