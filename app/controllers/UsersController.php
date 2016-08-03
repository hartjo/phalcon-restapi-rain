<?php

namespace Controllers;

//use Model Users
use Models\Users as Users;

class UsersController extends BaseController
{

	public function getUser() 
	{
		// phalcon default select method a bit slower than custom query method
		// $users = Users::find()->toArray();

		//faster than phalcon find method
        $users = $this->customQuery("SELECT * FROM users LIMIT 4");

        // all return must be an array
        return array(
        	'userlist' => $users
        	);

	}

	public function saveUser() {

		// all return must be an array
		return array(
        	'Save' => 'Save Use'
        	);
	}

}
// end of UserController Class
