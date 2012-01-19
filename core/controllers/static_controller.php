<?php


use jetstream\core\System;
use jetstream\core\debug\Debug;
use jetstream\core\http\Response;

class Static_Controller extends \jetstream\core\Controller {
	private $_extensions = array(
		'html' => array('content_type' => 'text/html'),
		'php' => array('content_type' => 'text/html'),
		'png' => array('content_type' => 'image/png'),
		'gif' => array('content_type' => 'image/gif'),
		'jpg' => array('content_type' => 'image/jpg'),
		'pdf' => array('content_type' => 'image/pdf'),
		'zip' => array('content_type' => 'application/zip'),
		'css' => array('content_type' => 'text/css'),
		'less' => array('content_type' => 'text/css'),
		'js' => array('content_type' => 'text/javascript')
	);

	public function action_render() {
		$path = $this->request->named['path'];
		$path_nodes = (isset($path)) ? preg_split("/\//", $path, -1, PREG_SPLIT_NO_EMPTY) : array();
		if ($path_nodes[0] == 'cache') {
			unset($path_nodes[0]);
			$info['path'] = APP_CACHE_PATH . DS . join(DS, $path_nodes);
		} else {
			$file_path = 'static/' . join(DS, $path_nodes);
			$info = System::findFile($file_path, array('app_build_path' => APP_PATH . DS . 'builds' . DS . $this->request->named['build_id']));
		}


		if ( $info && is_file($info['path']) ) {
			$info = $this->inspect($info['path']);
			$content = file_get_contents($info['path']);
			$response = new Response($content);
			$response->setStatusCode('200');
			$response->setContentType($info['content_type']);
			$response->setContentExpiry('+30 days');
		} else {
			$response = new Response('Not found');
			$response->setStatusCode('404');
			$response->setContentType('text/html');
			$response->setContentExpiry('+30 days');
		}

		return $response;
	}

	public function inspect($path) {
		$info = pathinfo($path);
		return $info + array('content_type' => $this->_extensions[$info['extension']]['content_type'], 'path' => $path);
	}
}