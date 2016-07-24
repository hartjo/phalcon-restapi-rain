<?php

/**
 * Micro Rest Application
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license none
*/

namespace Application;

use Phalcon\Loader;
use Phalcon\Exception;
use Phalcon\Mvc\Micro\Collection;
use Phalcon\Http\Request;

class Micro extends \Phalcon\Mvc\Micro {

	public $appDir;

	// constuct
	public function __construct() {
        $this->_noAuthPages = array();
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
					$collections[] = $this->microCollection($getcollection);
				}

				
			}
		}

		foreach($collections as $collection){
			$this->mount($collection);
		}
	
	}

	//create route collection
	private function microCollection($route){

		$cltn = new Collection();

		$cltn->setPrefix($route['prefix'])
			->setHandler($route['handler'])
			->setLazy($route['lazy']);

		foreach($route['collection'] as $r){

			if($r['authentication']===false){

				$method = strtolower($r['method']);

				if (! isset($this->_noAuthPages[$method])) {
					$this->_noAuthPages[$method] = array();
				}

				$this->_noAuthPages[$method][] = $route['prefix'].$r['route'];

			}

			$cltn->{$r['method']}($r['route'], $r['function']);
		}

		return $cltn;

	}



}
// end of class