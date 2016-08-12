<?php

namespace Controllers;

class BaseController extends \Phalcon\DI\Injectable 
{

    /**
     *  customQuery return all results
     */
	public function customQuery($sqlquery)
    {
		$dbconnection = $this->db;
		$stmt = $dbconnection->prepare($sqlquery);
		$stmt->execute();
		$result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return $result;
    }

    /**
     *  customQueryFirst return only one result
     */
    public function customQueryFirst($sqlquery)
    {
    	$dbconnection = $this->db;
    	$stmt = $dbconnection->prepare($sqlquery);
    	$stmt->execute();
    	$result = $stmt->fetch(\PDO::FETCH_ASSOC);
    	return $result;
    }

}
