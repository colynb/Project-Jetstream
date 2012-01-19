<?php

namespace jetstream\core;

use jetstream\core\data\Connection;
use jetstream\core\debug\Debug;

Connection::add(array(
	'blog' => array(
		'type' => 'database',
		'adapter' => 'mysql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'password' => 'root',
		'database' => 'jetstream',
		'encoding' => 'UTF-8',
	),
	'default_search' => array(
		'type' => 'search',
		'adapter' => 'AdobeSearch',
		'host'	=> 'auction.guided.ss-omtrdc.net',
		'port' => null,
		'protocol' => 'curl',
		'params' => array(
			'q' => '*',
			'proximity_search' => '1',
		)
	),
	'backup_search' => array(
		'type' => 'search',
		'adapter' => 'SolrSearch',
		'host'	=> 'localhost',
		'port' => null,
		'params' => array(
			'q' => '*'
		)
	),
));
