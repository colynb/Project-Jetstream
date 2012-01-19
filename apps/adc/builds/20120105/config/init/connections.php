<?php

namespace jetstream\core;

use jetstream\core\data\Connection;
use jetstream\core\debug\Debug;

Connection::add(array(
	'webuser_read' => array(
		'type' => 'database',
		'adapter' => 'mysql',
		'host' => 'ec2-174-129-68-106.compute-1.amazonaws.com',
		'port' => '3306',
		'user' => 'root',
		'password' => '9HQM3YCk',
		'database' => 'afwdb_dev2',
		'encoding' => 'UTF-8',
	),
	'webuser_write' => array(
		'type' => 'database',
		'adapter' => 'MySQL',
		'host' => 'ec2-174-129-68-106.compute-1.amazonaws.com',
		'port' => '3306',
		'user' => 'root',
		'password' => '9HQM3YCk',
		'database' => 'afwdb_dev2',
		'encoding' => 'UTF-8',
	),
	'messaging_server' => array(
		'type' => 'database',
		'adapter' => 'SMPAdaptor',
		'host' => 'ec2-174-129-68-106.compute-1.amazonaws.com',
		'port' => '5465',
	),
	'default_search' => array(
		'type' => 'search',
		'adapter' => 'adobe',
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






