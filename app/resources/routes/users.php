<?php
	
	/**
	 * Micro Rest Route Collection Users
	 *
	 * @package None
	 * @author  Jan Rainier Llarenas
	 * @license none
	*/


	$collection = [
		'prefix' => '/users/',
		'handler' => 'Controllers\UsersController',
		'lazy' => TRUE,
		'collection' => [

			[
				'method' => 'get',
				'route' => 'getuser',
				'function' => 'getUser',
				'authentication' => FALSE
			],

			[
				'method' => 'post',
				'route' => 'saveuser',
				'function' => 'saveUser',
				'authentication' => FALSE
			]

		]
	];

	return $collection;