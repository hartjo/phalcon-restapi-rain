<?php

namespace Controllers;

use Models\Users as Users;

class ExampleController extends BaseController {

	public function postPing() {
        // $users = Users::find()->toArray();
        $users = $this->customQuery("SELECT * FROM users");
        return array('array' => $users);
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
