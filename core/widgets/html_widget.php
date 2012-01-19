<?php

use jetstream\core\System;
use jetstream\core\Widget;
use jetstream\core\http\Response;
use jetstream\core\debug\Debug;
use jetstream\core\template\View;
use jetstream\core\template\Output;

class Html_Widget extends Widget {

	public $auto_queue = false;
	public $auto_container = false;

	public function css($vars = array()) {

		$local = array();
		$remote = array();
		$missing = array();
		$cache_string = APP_CACHE_ID;
		$html = array();

		foreach ( System::getQueued('css') as $k => $row ) {

			if ( in_array($row['info']['src'], $local + $remote) ) continue;

			if ( !preg_match("/^http/", $row['info']['src']) ) {
				$cache_string .= $row['info']['src'];
				$path = '/static' . str_replace(WEB_STATIC_PATH, '', $row['info']['src']);
				if ( $found = System::findFile($path) ) {
					$href = $row['info']['src'];
					$source = $found['path'];
					$local[] = compact('href', 'source');
				} else {
					$missing[] = $row['info']['src'];
				}
			} else {
				$remote[] = $row['info']['src'];
			}
		}


		// Load remote sources first
		foreach ( $remote as $k => $src ) {
			$html[] = $this->view->html->csslink(array(
				'href' => $src
			));
		}

		if ( System::$settings['debug_mode'] ) {
			foreach ( $local as $k => $src ) {
				$html[] = $this->view->html->csslink(array(
					'href' => $src['href']
				));
			}
			debug::console('Missing CSS', join("<br />\n", $missing));
		} else {
			$cached_file_href = WEB_STATIC_PATH . '/cache/css/' . hash('md5', APP_CACHE_ID . $cache_string) . '.css';
			$cached_file_source = APP_CACHE_PATH . '/css/' . hash('md5', APP_CACHE_ID . $cache_string) . '.css';
			if ( !is_file($cached_file_source) ) {
				$output = '';
				foreach ( $local as $k => $src ) {
					$header = "\n\n/*========================= " . $src['href'] . " =========================*/\n\n";
					$output .= $header . file_get_contents($src['source']);
				}
				file_put_contents($cached_file_source, $output);
			}
			$html[] = $this->view->html->csslink(array(
				'href' => $cached_file_href
			));
		}



		return "\n\t\t" . join("\n\t\t",$html);
	}

	public function js($vars = array()) {

		$local = array();
		$remote = array();
		$missing = array();
		$cache_string = APP_CACHE_ID;
		$html = array();

		foreach ( System::getQueued('js') as $k => $row ) {

			if ( in_array($row['info']['src'], $local + $remote) ) continue;

			if ( !preg_match("/^http/", $row['info']['src']) ) {
				$cache_string .= $row['info']['src'];
				$path = '/static' . str_replace(WEB_STATIC_PATH, '', $row['info']['src']);
				if ( $found = System::findFile($path) ) {
					$href = $row['info']['src'];
					$source = $found['path'];
					$local[] = compact('href', 'source');
				} else {
					$missing[] = $row['info']['src'];
				}
			} else {
				$remote[] = $row['info']['src'];
			}
		}


		// Load remote sources first
		foreach ( $remote as $k => $src ) {
			$html[] = $this->view->html->script(array(
				'src' => $src
			));
		}

		if ( System::$settings['debug_mode'] ) {
			foreach ( $local as $k => $src ) {
				$html[] = $this->view->html->script(array(
					'src' => $src['href']
				));
			}
			debug::console('Missing JS', join("<br />\n", $missing));
		} else {
			$cached_file_href = WEB_STATIC_PATH . '/cache/js/' . hash('md5', APP_CACHE_ID . $cache_string) . '.js';
			$cached_file_source = APP_CACHE_PATH . '/js/' . hash('md5', APP_CACHE_ID . $cache_string) . '.js';
			if ( !is_file($cached_file_source) ) {
				$output = '';
				foreach ( $local as $k => $src ) {
					$header = "\n\n/*========================= " . $src['href'] . " =========================*/\n\n";
					$output .= $header . file_get_contents($src['source']);
				}
				file_put_contents($cached_file_source, $output);
			}
			$html[] = $this->view->html->script(array(
				'src' => $cached_file_href
			));
		}



		return "\n\t\t" . join("\n\t\t",$html);
	}

}