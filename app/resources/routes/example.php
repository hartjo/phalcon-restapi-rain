<?php
	
	/**
	 * Micro Rest Route Collection Exmaple
	 *
	 * @package None
	 * @author  Jan Rainier Llarenas
	 * @license MIT
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
				'authentication' => TRUE
			],

			[
				'method' => 'get',
				'route' => 'get/ping',
				'function' => 'getPing',
				'authentication' => TRUE
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