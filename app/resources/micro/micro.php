<?php

/**
 * Micro Rest Application
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
*/

namespace Application;

use Phalcon\Loader;
use Phalcon\Exception;
use Phalcon\Mvc\Micro\Collection;
use Phalcon\Http\Request;

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

	// set autoload components
	public function setAutoload($file, $appDir) {
		
		if (!file_exists($file)) {
			throw new Exception('Unable to load autoloader file');
		}

		$namespaces = include $file;
		$loader = new Loader();
		$loader->registerNamespaces($namespaces)->register();

	}

	//set routes collection
	public function setRoutes() {

		$req = new Request();

		$reqUri = $req->getURI();

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