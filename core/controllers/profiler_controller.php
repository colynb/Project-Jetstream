<?php

use jetstream\core\debug\Debug;
use jetstream\core\debug\Profiler;

class Profiler_Controller extends \jetstream\core\Controller {
	protected $_layout = false;

	public function action_image() {

		$x = 250;
		$y = 20;

// Initialize the Image
		$image = imagecreatetruecolor($x, $y);

// Set the background Color
		$bg = isset($this->request->get['bg']) ? str_pad($this->request->get['bg'], 6, ' ') : 'FFFFFF';
		$r = hexdec(substr($bg, 0, 2));
		$g = hexdec(substr($bg, 2, 2));
		$b = hexdec(substr($bg, 4, 2));
		$background_color = imagecolorallocate($image, $r, $g, $b);

// Fill the image with the background color
		imagefilledrectangle($image, 0, 0, $x, $y, $background_color);

// gather the breadcrumbs for the image
		$crumbs = isset($this->request->get['time']) ? explode('^', $this->request->get['time']) : false;

		if ( !$crumbs ) {
			header("Content-type: image/jpeg");
			imagepng($image);
			exit;
		}

// calculate the total time from the first node
		$total = array_shift($crumbs);
		list($start_time, $end_time) = explode('|', $total);
		$start_time = (float) ($start_time * 1000);
		$end_time = (float) ($end_time * 1000);
		$total_time = $end_time - $start_time;

// calculate how many pixels per milisecond
		if ( $total_time == 0 ) {
			$x = 0;
		} else {
			$x_scale = $x / $total_time;
		}


// cycle through each subsequent breadcrumb and overlay it on the image
		foreach ( $crumbs as $index => $crumb ) {

			if ( empty($crumb) ) {
				continue;
			}

			list($node_start_time, $node_end_time) = explode('|', $crumb);

			$node_start_time = (float) ($node_start_time * 1000);
			$node_end_time = (float) ($node_end_time * 1000);

			$x_start = ($node_start_time - $start_time) * $x_scale;
			$x_end = ($node_end_time - $start_time) * $x_scale;

			$color_string = substr(hash('md5', ($x_start)), 0, 6);

			$r = hexdec(substr($color_string, 0, 2));
			$g = hexdec(substr($color_string, 2, 2));
			$b = hexdec(substr($color_string, 4, 2));
			$color = imagecolorallocate($image, $r, $g, $b);

			imagefilledrectangle($image, $x_start, 0, $x_end, $y, $color);
		}

		ob_start();
		imagepng($image);
		$content = ob_get_contents();

		$this->response->setStatusCode(200);
		$this->response->setContentExpiry('+30 days');
		$this->response->setContentType('image/png');
		$this->response->setContent($content);
		return $this->response;
	}

}