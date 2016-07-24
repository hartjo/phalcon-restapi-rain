<?php

/**
 * Micro Rest JsonResponse
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license none
 */

namespace App\Response;

use Phalcon\Http\Response;

class JsonResponse
{

	public static function make($result, $code = 200)
	{
		$responseArray = [
			'status' => $code,
			'status_message' => $code,
			'result' => $result
		];

		if (is_array($result)) {
			$responseArray['count'] = count($result);
		} else if (is_object($result)) {
			$responseArray['count'] = 1;
		}

		$response = new Response();
		$response->setJsonContent($responseArray);
		$response->setStatusCode($code);
		$response->setHeader('Access-Control-Allow-Origin', '*');
		$response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');    
		$response->setContentType('application/json');

		return $response;
	}
}