# Phalcon Micro Rest Api #

Phalcon Restful API that uses Phalcon Micro framework (works with Phalcon 2.0+ and 3.0)

The framework requires PHP 5.4, 5.5, 5.6 and PHP7

### What is this repository for? ###

* Phalcon Micro Rest Application
* Version 1.0
* [Learn Markdown](https://docs.phalconphp.com/en/latest/reference/tutorial-rest.html)

### How do I get set up? ###

* Clone repo
* change to root directory "cd phalcon-restapi-rain"
* run "composer install" without qoute to install php classes

### Requirements ###
---------
PHP 5.4 or greater

Required PHP Modules
- Phalcon (http://phalconphp.com/en/download)
- PDO-MySQL

Database Configuration
--------------
Open  `phalcon-restapi-rain/config/config.env.php` and setup your database connection credentials

```php
$settings = array(
        'database' => array(
                'adapter' => 'Mysql', /* Possible Values: Mysql, Postgres, Sqlite */
                'host' => 'your_ip_or_hostname',
                'username' => 'your_username',
                'password' => 'your_password',
                'name' => 'your_database_schema',
                'port' => 3306
        ),
);
```

you can use my sample schema in `phalcon-restapi-rain/schema/rainrest.sql`


Routes
-------------
Routes are stored in `phalcon-restapi-rain/app/resources/routes` as an array. A route has a method (HEAD, GET, POST, PATCH, DELETE, OPTIONS), uri (which can contain regular expressions) and handler/controller to point to.

`phalcon-restapi-rain/app/resources/routes/exaple.php`

```php
  $collection = [
		'prefix' => '/example/',
		'handler' => 'Controllers\ExampleController',
		'lazy' => TRUE,
		'collection' => [
		
			[
				'method' => 'post',
				'route' => 'post/ping',
				'function' => 'postPing',
				'authentication' => FALSE
			],

			[
				'method' => 'get',
				'route' => 'get/ping/{id}',
				'function' => 'getPing',
				'authentication' => FALSE
			],

			[
				'method' => 'put',
				'route' => 'put/ping',
				'function' => 'putPing',
				'authentication' => TRUE
			],

			[
				'method' => 'delete',
				'route' => 'delete/ping',
				'function' => 'deletePing',
				'authentication' => FALSE
			]

		]
	];
	
return $collection;
```

`phalcon-restapi-rain/app/resources/routes/users.php`

```php
$collection = [
	'prefix' => '/users/',
	'handler' => 'Controllers\UsersController',
	'lazy' => TRUE,
	'collection' => [

		[
			'method' => 'get',
			'route' => 'getuser',
			'function' => 'getUser',
			'authentication' => FALSE
		],

		[
			'method' => 'post',
			'route' => 'saveuser',
			'function' => 'saveUser',
			'authentication' => FALSE
		]

	]
];

return $collection;
```


Test Routes
-------------
to test route either use Postman plugin of google chrome or any other api testing application

Note! change http://rainrestv1.dev use your own hostname

POST Method
url: http://rainrestv1.dev/example/post/ping

Response : 
```json
{
  "status": 200,
  "status_message": "OK",
  "result": [
    {
      "postpong": "pong - post method"
    }
  ],
  "count": 1
}
```

GET Method
url: http://rainrestv1.dev/example/get/ping/12345

Response : 
```json
{
  "status": 200,
  "status_message": "OK",
  "result": [
    {
      "getpong": "pong - get method",
      "id": "12345"
    }
  ],
  "count": 1
}
```

PUT Method
url: http://rainrestv1.dev/example/put/ping

Response : 
```json
{
  "status": 200,
  "status_message": "OK",
  "result": [
    {
      "putpong": "pong - put method"
    }
  ],
  "count": 1
}
```

DELETE Method
url: http://rainrestv1.dev/example/delete/ping

Response : 
```json
{
  "status": 200,
  "status_message": "OK",
  "result": [
    {
      "deletepong": "pong - delete method"
    }
  ],
  "count": 1
}
```


GET Method
url: http://rainrestv1.dev/users/getuser

Response : 
```json
{
  "status": 200,
  "status_message": "OK",
  "result": [
    {
      "userlist": [
        {
          "id": "1",
          "name": "Jan Rainier Llarenas",
          "username": "superagent",
          "password": "1234568"
        },
        {
          "id": "2",
          "name": "Janine Hazel Labadia",
          "username": "superlady",
          "password": "1234568"
        },
        {
          "id": "3",
          "name": "Heaven Leih Mojica",
          "username": "superbabs",
          "password": "12345678"
        },
        {
          "id": "4",
          "name": "Jonalyn Hazel Cajalne",
          "username": "superslim",
          "password": "1234568"
        }
      ]
    }
  ],
  "count": 1
}
```


### Who do I talk to? ###

* Owner Jan Rainier Llarenas <llarenasjanrainier@gmail.com>
* Contributor Neil Male <neilmaledev@gmail.com>
* Contributor Hazel Cajalne <hazelcajalne99@gmail.com>
