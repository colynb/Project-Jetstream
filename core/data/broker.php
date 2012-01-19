<?php

namespace jetstream\core\data;
use jetstream\core\data\Connection;
use jetstream\core\debug\Debug;

class Broker {

	public function request_websession($params) {

		$sql = 'SELECT
					ws.said,
					ws.session_index,
					ws.sip,
					ws.salt,
					wu.party_id,
					ws.web_user_id,
					ws.email_address,
					ws.web_username,
					ws.market_id,
					ws.domain_id,
					ws.first_activity_datetime,
					ws.last_activity_datetime,
					ws.expiration_datetime,
					ws.browser_info,
					ws.force_action,
					ws.user_status,
					ws.user_info
		 		FROM
					`WEB_SESSION` ws
				LEFT JOIN
					WEB_USER wu
						on ws.web_user_id = wu.web_user_id
				WHERE
					`said` = ::(string)said
				LIMIT 1';

		$results = Connection::get('webuser_read')->getRow($sql, $params);

		if ( $results ) {

			$results['user_info'] = unserialize(stripslashes($results['user_info']));
		}


		return $results;
	}
}