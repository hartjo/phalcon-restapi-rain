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
				'method' => 'post',
				'route' => 'post/ping',
				'function' => 'postPing',
				'authentication' => FALSE
			],

			[
				'method' => 'get',
				'route' => 'get/ping/{id}',
				'function' => 'getPing',
				'authentication' => FALSE
			],

			[
				'method' => 'put',
				'route' => 'put/ping',
				'function' => 'putPing',
				'authentication' => FALSE
			],

			[
				'method' => 'delete',
				'route' => 'delete/ping',
				'function' => 'deletePing',
				'authentication' => FALSE
			]

		]
	];

	return $collection;