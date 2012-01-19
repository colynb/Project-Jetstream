<?php

use jetstream\core\System;
use jetstream\core\http\Router;
use jetstream\core\debug\Debug;

class JqueryUI_Helper extends jetstream\core\Helper {

	public function datepicker($params) {

		/**
		 * @import url("jquery.ui.core.css");
		  @import url("jquery.ui.resizable.css");
		  @import url("jquery.ui.selectable.css");
		  @import url("jquery.ui.accordion.css");
		  @import url("jquery.ui.autocomplete.css");
		  @import url("jquery.ui.button.css");
		  @import url("jquery.ui.dialog.css");
		  @import url("jquery.ui.slider.css");
		  @import url("jquery.ui.tabs.css");
		  @import url("jquery.ui.datepicker.css");
		  @import url("jquery.ui.progressbar.css");
		 */

		$this->view->queue('css', array('src' => '/css/jquery-ui/themes/adc/jquery.ui.core.css'));
		$this->view->queue('css', array('src' => '/css/jquery-ui/themes/adc/jquery.ui.datepicker.css'));


		$this->view->queue('css', array('src' => '/css/jquery-ui/themes/adc/jquery.ui.theme.css'));
		$this->view->queue('js', array('src' => '/js/jquery/plugins/jquery-ui/jquery.ui.core.min.js'));
		$this->view->queue('js', array('src' => '/js/jquery/plugins/jquery-ui/jquery.ui.datepicker.min.js'));

		$html = '<input type="hidden" name="' . $params['name'] . '" id="' . $params['id'] . '" value="' . $params['start_date'] . '" />
		<div id="' . $params['id'] . '-container"></div>';
		return $html;
	}

}