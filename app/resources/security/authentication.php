<?php

/**
 * Micro Rest Authentication
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
 */

namespace App\Security;

use App\Response\JsonResponse;

class SecurityApp {

	public static function sample($app){

		$method = strtolower($app->router->getMatchedRoute()->getHttpMethods());
		$unAuthenticated = $app->routeAllowed();

		if(isset($unAuthenticated[$method])) {
			$unAuthenticated = array_flip($unAuthenticated[$method]);

			if (isset($unAuthenticated[$app->router->getMatchedRoute()->getPattern()])) {
				return true; 
			} 
		}


		JsonResponse::make('Your not allowed!', 401)->send();
		return false;
		
	}



}