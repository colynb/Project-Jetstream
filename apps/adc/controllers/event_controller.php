<?php

class Event_Controller extends \jetstream\core\Controller {

	public function action_calendar() {
		$named = array(
			'event_type' => 'all',
		);
		$query = array(
			'property_type' => 'all',
			'event_date' => date('Y-m-d'),
		);

		if (is_array($this->request->named)) {
			$named = $this->request->named + $named;
		}

		if (is_array($this->request->get)) {
			$query = $this->request->get + $query;
		}

		$this->view->set(compact('query', 'named'));

	}

	public function action_detail() {



		if (isset($this->request->named['event_id'])) {
			$event_id = $this->request->named['event_id'];
		} else {
			return false;
		}

		$this->view->set(compact('event_id'));

	}

}