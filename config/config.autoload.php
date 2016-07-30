<?php

/**
 * Micro Rest autoload
 *
 * @package None
 * @author  Jan Rainier Llarenas
 * @license MIT
 */


$autoload = [
	'App\Security' => $appDir .'/resources/security/',
	'Controllers' => $appDir .'/controllers/',
	'Models' => $appDir .'/models/'
];

return $autoload;
