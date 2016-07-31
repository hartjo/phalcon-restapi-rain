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


Routes
-------------
Routes are stored in `phalcon-restapi-rain/app/resources/routes/exaple.php` as an array. A route has a method (HEAD, GET, POST, PATCH, DELETE, OPTIONS), uri (which can contain regular expressions) and handler/controller to point to.

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
				'route' => 'get/ping',
				'function' => 'getPing',
				'authentication' => TRUE
			],
			[
				'method' => 'put',
				'route' => 'put/ping',
				'function' => 'putPing',
				'authentication' => FALSE
			],
		]
	];
	
return $collection;
```

### Who do I talk to? ###

* Owner Jan Rainier Llarenas <llarenasjanrainier@gmail.com>
* Contributor Neil Male <neilmaledev@gmail.com>
* Contributor Hazel Cajalne <hazelcajalne99@gmail.com>
