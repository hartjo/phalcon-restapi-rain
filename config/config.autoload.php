<?php

/**
 * Micro Rest autoload
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
 */


$autoload = [
	'App\Response' => $appDir .'/resources/response/response',
	'Controllers' => $appDir .'/controllers/',
	'Models' => $appDir .'/models/'
];

return $autoload;
