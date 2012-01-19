<?php

class Search_Controller extends \jetstream\core\Controller {

	public function action_results() {

		if ( isset($this->request->named) ) {
			$named = $this->request->named;
		}

		if ( isset($this->request->get) ) {
			$query = $this->request->get;
		}

		$search = new \libraries\search\Search();

		$results = $search->getResults();
		$sort_options = $search->getSortOptions();
		$pagination = $search->getPagination();
		$refinements = $search->getRefinements();

		///$search->setParams($params);

		$this->view->set(compact(
			'named',
			'query',
			'results',
			'sort_options',
			'pagination',
			'refinements'
		));
	}

}