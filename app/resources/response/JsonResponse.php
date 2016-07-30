<?php

/**
 * Micro Rest JsonResponse
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
 */

namespace App\Response;

use Phalcon\Http\Response;

class JsonResponse{

	public static function make($result, $code = 200){
		$responseArray = [
			'status' => $code,
			'status_message' => self::getResponseDescription($code),
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

	public static function error($result, $code = 200){
		$responseArray = [
			'status' => $code,
			'status_message' => self::getResponseDescription($code),
			'Error_message' => $result->getMessage(),
			'dev' => $result->devMessage,
			'Internal_code' => $result->errorCode,
			'more' => $result->additionalInfo,
		];

		$response = new Response();
		$response->setJsonContent($responseArray);
		$response->setStatusCode($code);
		$response->setHeader('Access-Control-Allow-Origin', '*');
		$response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');    
		$response->setContentType('application/json');

		return $response;
	}

	public static function errorParse($result, $code = 200){
		$responseArray = [
			'status' => $code,
			'status_message' => self::getResponseDescription($code),
			'Error_message' => $result['message'],
			'File' => $result['file'],
			'Error_line' => $result['line'],
		];

		$response = new Response();
		$response->setJsonContent($responseArray);
		$response->setStatusCode($code);
		$response->setHeader('Access-Control-Allow-Origin', '*');
		$response->setHeader('Access-Control-Allow-Headers', 'X-Requested-With');    
		$response->setContentType('application/json');

		return $response;
	}

	public static function getResponseDescription($code){
		$codes = array(

			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',

			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',

			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',  // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',

			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',

			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded'
		);

		$result = (isset($codes[$code])) ?
			$codes[$code]          :
			'Unknown Status Code';

		return $result;
	}
}