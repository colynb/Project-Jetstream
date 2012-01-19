<?php

namespace jetstream\core;

use jetstream\core\http\Router;


Router::set('home', '/', 'Home::view');
Router::set('blog-home', '/blog/', 'Blog::view');
Router::set('blog-post', '/blog/post/{:post_key}/{:args}', 'Blog::show');
Router::set('static', '/static/{:build_id}-{:cache_id}/{:args}', 'Static::render');

Router::set('api', '/api/{:version}/{:class}/{:method}/{:args}', 'Api::init', array('version' => 'v1'));

// Default route
Router::set('default', '/{:controller}/{:action}/{:args}');