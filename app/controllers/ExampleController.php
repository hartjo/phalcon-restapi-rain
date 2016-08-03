<?php

namespace Controllers;

class ExampleController extends BaseController
{

	public function postPing()
    {
      

         // all return must be an array
        return array(
            'postpong'=>'pong - post method'
            );

    }
    
    public function getPing($id)
    {

        // all return must be an array
        return array(
            'getpong'=>'pong - get method',
            'id'=> $id
            );

    }

    public function putPing()
    {

        // all return must be an array
		return array(
            'putpong'=>'pong - put method'
            );
	}


    public function deletePing() 
    {

         // all return must be an array
    	return array(
            'deletepong'=>'pong - delete method'
            );

    }
    
}
