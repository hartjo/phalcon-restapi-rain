<?php

namespace Controllers;

class ExampleController extends \Phalcon\Mvc\Controller {

	public function postPing() {
        return array('sad' =>'post pong');
    }

    public function getPing() {
        return "pong get";
    }

    public function putPing() {
		return "pong put";
	}

    public function testAction($id) {
        return "test (id: $id)";
    }

    public function skipAction($name) {
        return "auth skipped ($name)";
    }
    
    public function getAction() {
    	return "pong - get method";
    }
    
    public function putAction() {
    	return "pong - put method";
    }
    
    public function deleteAction() {
    	return "pong - delete method";
    }
    
}
