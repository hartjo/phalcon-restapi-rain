<?php
	
	/**
	 * Micro Rest Route Collection Exmaple
	 *
	 * @package None
	 * @author  Jan Rainier Llarenas
	 * @license none
	*/


	$collection = [
		'prefix' => '/example/',
		'handler' => 'Controllers\ExampleController',
		'lazy' => TRUE,
		'collection' => [
		
			[
				'method' => 'get',
				'route' => 'post/ping',
				'function' => 'postPing',
				'authentication' => FALSE
			],

			[
				'method' => 'get',
				'route' => 'get/ping',
				'function' => 'getPing',
				'authentication' => FALSE
			],

			[
				'method' => 'put',
				'route' => 'put/ping',
				'function' => 'putPing',
				'authentication' => FALSE
			],

		]
	];

	return $collection;