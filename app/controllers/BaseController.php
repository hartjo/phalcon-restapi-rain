<?php

namespace Controllers;

use \Phalcon\DI;

class BaseController extends \Phalcon\DI\Injectable {

	public function customQuery($phql) {
		$dbbnb = DI::getDefault()->get('db');
		$stmt = $dbbnb->prepare($phql);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
    }

    public function customQueryFirst($phql) {
    	$dbbnb = DI::getDefault()->get('db');
    	$stmt = $dbbnb->prepare($phql);
    	$stmt->execute();
    	$result = $stmt->fetch(\PDO::FETCH_ASSOC);
    	return $result;
    }

}
