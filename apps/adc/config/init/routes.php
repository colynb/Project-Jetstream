<?php

/**
 * Project Jetstream
 *
 * @copyright     Copyright 2012, Colyn Brown
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */
use jetstream\core\System;
use jetstream\core\http\Router;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;

/**
 *  ====== Gateway Home ======
 */
Router::set('home', '/', 'Home::gateway', array('vmarket' => 'home'));

/**
 *  ===== Static File Route ======
 *
 * Used for accessing static files like css, js, and images that are not within the
 * webroot.
 *
 * The provided Static controller parses and compiles the content and prepares it for output.
 */
Router::set('static', '/static/{:build_id}-{:cache_id}/{:path:.*}', 'Static::render');
Router::set('flickr', '/flickr/{:args}', function(){
	echo 'asdasd';
	return new Response('');
} );

/**
 * Development Only Routes
 */
if ( System::$env !== 'production' ) {
	Router::set('dev', '/dev/{:args}', 'Api::init', array('version' => 'v1'));
}

/**
 * API Routes
 */
Router::set('api', '/api/{:version}/{:class}/{:method}/{:args}', 'Api::init', array('version' => 'v1'));

/**
 * Event Calendar Routes
 */
Router::set('event-calendar', '/{:vmarket}/event/calendar/{:event_type}/{:args}', 'Event::calendar', array('event_type' => 'all', 'vmarket' => 'real-estate'));
Router::set('event-detail', '/{:vmarket}/event/detail/{:event_id}/{:args}', 'Event::detail', array('vmarket' => 'real-estate'));



Router::set('search-home', '/{:vmarket}/search/', 'Search::results', array('property_type' => 'all', 'vmarket' => 'real-estate'));
Router::set('search-category', '/{:vmarket}/search/{:category}/', 'Search::results', array('property_type' => 'all', 'vmarket' => 'real-estate'));
Router::set('search-type', '/{:vmarket}/search/{:category}/{:property_type}/{:args}', 'Search::results', array('property_type' => 'all', 'vmarket' => 'real-estate'));

/**
 *  ====== Account Routes ======
 */
Router::set('account-home', '/{:vmarket}/account/', 'Account::index', array('vmarket' => 'real-estate'));
Router::set('account-default', '/{:vmarket}/account/{:action}/{:args}', array('vmarket' => 'account'));



/**
 *  ====== Support Routes ======
 */
Router::set('support-home', '/{:vmarket}/support/', 'Support::index', array('vmarket' => 'real-estate'));
Router::set('support-default', '/{:vmarket}/support/{:action}/{:args}', array('controller' => 'support'));


/**
 *  ====== Vertical Market Home and Default ======
 */
Router::set('vmarket-home', '/{:vmarket}/', 'Home::vmarket');
Router::set('vmarket-default', '/{:vmarket}/{:controller}/{:action}/{:args}');


Router::set('home')
	->route('/home/')
	->to('Home::index')
	->accepts('GET','POST');



Router::set('default', '/{:controller}/{:action}/{:args}');