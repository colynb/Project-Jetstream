<?php

use jetstream\core\webservice\WebService;

class Adobe {
	private $_config;
	private $_executed;
	private $_results;
	private $_meta;
	private $_refinements;
	private $_breadcrumb;
	private $_sort_options;
	private $_pagination;
	private $_params;
	private $_class_type = 'adobe';
	private $_delimiter = ';';
	public function __construct($config) {

		$this->webservice = new WebService();

		$this->_config = $config;

		if ( is_array($this->_config['params']) ) {
			$this->_params = $this->_config['params'];
		}
	}

	public function execute($params) {
		if ( $this->_executed ) {
			return true;
		}

		$this->_executed = true;

		// API code to generate XML result goes here
		// Parse XML as arrays into the following sections
		$this->webservice->setConfig($this->_config);
		$this->webservice->setParams($this->getParams());
		$this->webservice->call();

		// Generate Results array
		$this->setResults($this->webservice->getXmlResponse()->Results);

		// Generate Meta data array (total, page count etc)
		$this->setMeta($this->webservice->getXmlResponse()->Query);

		// Generate Refinements array (facets)
		$this->setRefinements($this->webservice->getXmlResponse()->Facets);

		// Generate Sort array (sort)
		$this->setSortOptions($this->webservice->getXmlResponse()->Sort);

		// Generate Sort array (sort)
		$this->setBreadcrumb($this->webservice->getXmlResponse()->Breadcrumb);

		// Generate Pagination array (facets)
		$this->setPagination($this->webservice->getXmlResponse()->Pagination);
	}

	public function setParam($name=null, $value) {
		if ( $name == null ) {
			return false;
		}
		$param = array(
			$name => $value
		);
		$this->_params += $param;
	}

	public function setParams($params) {
		$this->_params += $params;
	}

	public function getParams() {
		return $this->_params;
	}

	private function setResults($results) {
		$results = $results->result;
		$this->_results = array();

		$count = count($results);
//		Debug::dump($results);
		for ( $i = 0; $i < $count; $i++ ) {
			$this->_results[] = array(
				'INDEX' => (int) $results[$i]->index,
				'MARKET' => array(
					'display' => (string) $results[$i]->MARKET->attributes()->display_name,
					'value' => (string) $results[$i]->MARKET,
				),
				'PRODUCT_TYPE' => array(
					'display' => (string) $results[$i]->PRODUCT_TYPE->attributes()->display_name,
					'value' => (string) $results[$i]->PRODUCT_TYPE,
				),
				'PRODUCT_VERTICAL' => array(
					'display' => (string) $results[$i]->PRODUCT_VERTICAL->attributes()->display_name,
					'value' => (string) $results[$i]->PRODUCT_VERTICAL,
				),
				'PRODUCT_CATEGORY' => array(
					'display' => (string) $results[$i]->PRODUCT_CATEGORY->attributes()->display_name,
					'value' => (string) $results[$i]->PRODUCT_CATEGORY,
				),
				'PRODUCT_SUBCATEGORY' => array(
					'display' => (string) $results[$i]->PRODUCT_SUBCATEGORY->attributes()->display_name,
					'value' => (string) $results[$i]->PRODUCT_SUBCATEGORY,
				),
				'ASSET_ID' => array(
					'display' => (string) $results[$i]->ASSET_ID->attributes()->display_name,
					'value' => (int) $results[$i]->ASSET_ID,
				),
				'EVENT_ID' => array(
					'display' => (string) $results[$i]->EVENT_ID->attributes()->display_name,
					'value' => (string) $results[$i]->EVENT_ID,
				),
				'PRODUCT_STATUS' => array(
					'display' => (string) $results[$i]->PRODUCT_STATUS->attributes()->display_name,
					'value' => (string) $results[$i]->PRODUCT_STATUS,
				),
				'SALE_TYPE' => array(
					'display' => (string) $results[$i]->SALE_TYPE->attributes()->display_name,
					'value' => (string) $results[$i]->SALE_TYPE,
				),
				'PROPERTY_NAME' => array(
					'display' => (string) $results[$i]->PROPERTY_NAME->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_NAME,
				),
				'PROPERTY_ADDRESS' => array(
					'display' => (string) $results[$i]->PROPERTY_ADDRESS->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_ADDRESS,
				),
				'PROPERTY_COUNTY' => array(
					'display' => (string) $results[$i]->PROPERTY_COUNTY->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_COUNTY,
				),
				'PROPERTY_CITY' => array(
					'display' => (string) $results[$i]->PROPERTY_CITY->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_CITY,
				),
				'PROPERTY_STATE' => array(
					'display' => (string) $results[$i]->PROPERTY_STATE->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_STATE,
				),
				'PROPERTY_ZIP' => array(
					'display' => (string) $results[$i]->PROPERTY_ZIP->attributes()->display_name,
					'value' => (int) $results[$i]->PROPERTY_ZIP,
				),
				'PROPERTY_SUBDIVISION' => array(
					'display' => (string) $results[$i]->PROPERTY_SUBDIVISION->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_SUBDIVISION,
				),
				'PROPERTY_DESCRIPTION' => array(
					'display' => (string) $results[$i]->PROPERTY_DESCRIPTION->attributes()->display_name,
					'value' => (string) $results[$i]->PROPERTY_DESCRIPTION,
				),
				'MLS_COMMENT' => array(
					'display' => (string) $results[$i]->MLS_COMMENT->attributes()->display_name,
					'value' => (string) $results[$i]->MLS_COMMENT,
				),
				'UNITS' => array(
					'display' => (string) $results[$i]->UNITS->attributes()->display_name,
					'value' => (int) $results[$i]->UNITS,
				),
				'BUILDINGS' => array(
					'display' => (string) $results[$i]->BUILDINGS->attributes()->display_name,
					'value' => (int) $results[$i]->BUILDINGS,
				),
				'BEDROOMS' => array(
					'display' => (string) $results[$i]->BEDROOMS->attributes()->display_name,
					'value' => (int) $results[$i]->BEDROOMS,
				),
				'BATHS' => array(
					'display' => (string) $results[$i]->BATHS->attributes()->display_name,
					'value' => (int) $results[$i]->BATHS,
				),
				'TOTAL_ROOM_COUNT' => array(
					'display' => (string) $results[$i]->TOTAL_ROOM_COUNT->attributes()->display_name,
					'value' => (int) $results[$i]->TOTAL_ROOM_COUNT,
				),
				'LOT_SIZE' => array(
					'display' => (string) $results[$i]->LOT_SIZE->attributes()->display_name,
					'value' => (int) $results[$i]->LOT_SIZE,
				),
				'LOT_SIZE_TIER' => array(
					'display' => (string) $results[$i]->LOT_SIZE_TIER->attributes()->display_name,
					'value' => (int) $results[$i]->LOT_SIZE_TIER,
				),
				'SQUARE_FOOTAGE' => array(
					'display' => (string) $results[$i]->SQUARE_FOOTAGE->attributes()->display_name,
					'value' => (int) $results[$i]->SQUARE_FOOTAGE,
				),
				'SQUARE_FOOTAGE_TIER' => array(
					'display' => (string) $results[$i]->SQUARE_FOOTAGE_TIER->attributes()->display_name,
					'value' => (string) $results[$i]->SQUARE_FOOTAGE_TIER,
				),
				'RENTABLE_SQUARE_FOOTAGE' => array(
					'display' => (string) $results[$i]->RENTABLE_SQUARE_FOOTAGE->attributes()->display_name,
					'value' => (int) $results[$i]->RENTABLE_SQUARE_FOOTAGE,
				),
				'LIST_PRICE' => array(
					'display' => (string) $results[$i]->LIST_PRICE->attributes()->display_name,
					'value' => (float) $results[$i]->LIST_PRICE,
				),
				'LIST_PRICE_TIER' => array(
					'display' => (string) $results[$i]->LIST_PRICE_TIER->attributes()->display_name,
					'value' => (string) $results[$i]->LIST_PRICE_TIER,
				),
				'EVENT_ASSET_ID' => array(
					'display' => (string) $results[$i]->EVENT_ASSET_ID->attributes()->display_name,
					'value' => (string) $results[$i]->EVENT_ASSET_ID,
				),
				'EVENT_DATE' => array(
					'display' => (string) $results[$i]->EVENT_DATE->attributes()->display_name,
					'value' => (string) $results[$i]->EVENT_DATE,
				),
				'BIDDING_START_DATETIME' => array(
					'display' => (string) $results[$i]->BIDDING_START_DATETIME->attributes()->display_name,
					'value' => (string) $results[$i]->BIDDING_START_DATETIME,
				),
				'BIDDING_END_DATETIME' => array(
					'display' => (string) $results[$i]->BIDDING_END_DATETIME->attributes()->display_name,
					'value' => (string) $results[$i]->BIDDING_END_DATETIME,
				),
				'STARTING_BID' => array(
					'display' => (string) $results[$i]->STARTING_BID->attributes()->display_name,
					'value' => (float) $results[$i]->STARTING_BID,
				),
				'YEAR_BUILT' => array(
					'display' => (string) $results[$i]->YEAR_BUILT->attributes()->display_name,
					'value' => (int) $results[$i]->YEAR_BUILT,
				),
				'IS_FINANCING_AVAILABLE' => array(
					'display' => (string) $results[$i]->IS_FINANCING_AVAILABLE->attributes()->display_name,
					'value' => (bool) $results[$i]->IS_FINANCING_AVAILABLE,
				),
				'IS_FEATURED' => array(
					'display' => (string) $results[$i]->IS_FEATURED->attributes()->display_name,
					'value' => (bool) $results[$i]->IS_FEATURED,
				),
				'CURRENT_PRICE' => array(
					'display' => (string) $results[$i]->CURRENT_PRICE->attributes()->display_name,
					'value' => (float) $results[$i]->CURRENT_PRICE,
				),
				'LATITUDE' => array(
					'display' => (string) $results[$i]->LATITUDE->attributes()->display_name,
					'value' => (float) $results[$i]->LATITUDE,
				),
				'LONGITUDE' => array(
					'display' => (string) $results[$i]->LONGITUDE->attributes()->display_name,
					'value' => (float) $results[$i]->LONGITUDE,
				),
				'IS_LAND_ONLY' => array(
					'display' => (string) $results[$i]->IS_LAND_ONLY->attributes()->display_name,
					'value' => (bool) $results[$i]->IS_LAND_ONLY,
				),
				'ASSET_IMAGES' => array(
					'display' => (string) $results[$i]->ASSET_IMAGES->attributes()->display_name,
					'value' => (string) $results[$i]->ASSET_IMAGES->attributes()->ASSET_IMAGE,
				),
				'RECENCY' => array(
					'display' => (string) $results[$i]->RECENCY->attributes()->display_name,
					'value' => (int)$results[$i]->RECENCY,
				),
				/*'DISTANCE' => array(
					'display' => (string) $results[$i]->DISTANCE->attributes()->display_name,
					'value' => (float)$results[$i]->DISTANCE,
				)*/
			);

			foreach ( $results[$i]->ASSET_IMAGES->ASSET_IMAGE as $assetImage ) {
				$this->_results[$i]['ASSET_IMAGES']['value'][] = array(
					'display' => (string) $assetImage->attributes()->display_name,
					'value' => (string) $assetImage,
				);
			}
		}
	}

	public function getResults($type = false) {
		$this->execute($this->_params);

		if ( $type == 'json' ) {
			return json_encode($this->_results);
		}
		return $this->_results;
	}

	private function setMeta($meta) {
		$this->_meta = array();

		$this->_meta['query'] = (array) $meta->{'user-query'};
		$this->_meta['minimum'] = (array) $meta->{'lower-results'};
		$this->_meta['maximum'] = (array) $meta->{'upper-results'};
		$this->_meta['total'] = (array) $meta->{'total-results'};
	}

	public function getMeta() {
		$this->execute($this->_params);
		return $this->_meta;
	}

	private function setRefinements($refinements) {
		$refinements = $refinements->{'facet-item'};


		$this->_refinements = array();

		$count = count($refinements);
		for ( $i = 0; $i < $count; $i++ ) {
		\jetstream\core\debug\Debug::console('Refinements XML', $refinements[$i]);
			$this->_refinements[] = array(
				'title' => (string) $refinements[$i]->{'facet-title'},
			);

			$subCount = count($refinements[$i]->{'facet-value'});
			for ( $j = 0; $j < $subCount; $j++ ) {
				$this->_refinements[$i]['value'][] = array(
					'selected' => ( (string) $refinements[$i]->{'facet-value'}[$j]->selected ) ? true : false,
					'label' => (string) $refinements[$i]->{'facet-value'}[$j]->label,
					'link' => (string) str_replace(';', '&', $refinements[$i]->{'facet-value'}[$j]->link),
					'undolink' => (string) str_replace(';', '&', $refinements[$i]->{'facet-value'}[$j]->undolink),
					'count' => (int) $refinements[$i]->{'facet-value'}[$j]->count,
				);
			}
		}
	}

	private function setBreadcrumb($breadcrumb) {
		$breadcrumb = $breadcrumb->{'Breadcrumb-Item'};
		$this->_breadcrumb = array();

		$count = count($breadcrumb);
		for ( $i = 0; $i < $count; $i++ ) {
			$this->_breadcrumb[] = array(
				'item' => (array) $breadcrumb[$i]->{'breadcrumb-goto-item'},
				'item-remove' => (array) $breadcrumb[$i]->{'breadcrumb-remove-item'},
			);
		}
	}

	private function setSortOptions($sort) {
		$sort = $sort->{'sort-item'};
		$this->_sort_options = array();

		$count = count($sort);
		for ( $i = 0; $i < $count; $i++ ) {
			$this->_sort_options[] = array(
				'label' => (string) $sort[$i]->{'label'},
				'value' => (string) $sort[$i]->{'value'},
				'link' => (string) $sort[$i]->{'link'},
				'selected' => (bool) $sort[$i]->attributes()->selected,
			);
		}
	}

	public function getRefinements() {
		$this->execute($this->_params);
		return $this->_refinements;
	}

	public function getSortOptions() {
		$this->execute($this->_params);
		return $this->_sort_options;
	}

	private function setPagination($pagination) {
		$this->_pagination = array();

		$this->_pagination = array(
			'total' => (int) $pagination->{'total-pages'},
			'pages' => array(),
		);

		$count = count($pagination->page);
		for ( $i = 0; $i < $count; $i++ ) {
			$this->_pagination['pages'][] = array(
				'position' => is_numeric($position = (string) $pagination->page[$i]->attributes()->position) ? (int) $position : (string) $position,
				'link' => (string) str_replace(';', '&', $pagination->page[$i]),
				'selected' => (bool) $pagination->page[$i]->attributes()->selected,
			);
		}
	}

	public function getPagination() {
		$this->execute($this->_params);
		return $this->_pagination;
	}

	public function getBreadcrumb() {
		$this->execute($this->_params);
		return $this->_breadcrumb;
	}

	public function classType() {
		return $this->_class_type;
	}
}

?>
