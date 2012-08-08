<?php

use jetstream\core\debug\Debug;
use jetstream\core\template\View;

if ( is_array($posts) ) {
	foreach ( $posts as $post ) {
		echo $this->html->link(array(
			'label' => $post['title'],
			'route' => 'blog-post',
			'args' => array('post_key' => $post['url_key'])
		));
		echo '<br />';
	}
}
