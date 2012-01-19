<?php

namespace jetstream\core\session;

use jetstream\core\System;
use jetstream\core\data\Broker;
use jetstream\core\debug\Debug;

class UserAuth {
	private $_cookie_name;
	private $_default_webauth;
	public $webauth;
	public $status;



	public function testinit() {
		$said = '4335e0ea938697e0eefb5e9d3f2a0f69';
		$session = System::data()->request_websession(compact('said'));
	}

	public function init() {

		$temp = array(
			'salt' => hash('md5', (microtime() . rand())),
			'browser_info' => isset(System::request()->server['HTTP_USER_AGENT']) ? System::request()->server['HTTP_USER_AGENT'] : 'unknown',
		);

		$this->_cookie_name = System::$var['domain'] . '_webauth';
		$this->_default_webauth = new ArrayRegistry(array(
			'sip' => System::request()->server['REMOTE_ADDR'],
			'salt' => $temp['salt'],
			'said' => hash('md5', ($temp['browser_info'] . $temp['salt'])),
			'email_address' => '',
			'web_username' => '',
			'market_id' => System::Build()->info['market_id'],
			'domain_id' => System::Build()->info['domain_id'],
			'party_id' => '',
			'web_user_id' => '',
			'first_activity_datetime' => date('Y-m-d H:i:s', System::$var['timestamp']),
			'last_activity_datetime' => date('Y-m-d H:i:s', System::$var['timestamp']),
			'expiration_datetime' => date('Y-m-d H:i:s', System::$var['timestamp'] + ( 3600 * 24 * 365)),
			'browser_info' => $temp['browser_info'],
			'force_action' => 'none',
			'user_status' => 'guest',
			'user_info' => array(),
		));

		$params = array(
			'said' => isset(System::request()->cookie[$this->_cookie_name]) ? System::request()->cookie[$this->_cookie_name] : $this->_default_webauth['said'],
		);

		$session = System::Messenger()->webUser_session_request($params);

		if ( !$session ) {
			$this->webauth = $this->_default_webauth;
		} elseif ( $params['said'] != hash('md5', ($temp['browser_info'] . $session['salt'])) ) {
			$this->webauth = $this->_default_webauth;
		} else {
			$this->webauth = new ArrayRegistry($session);
		}

		if ( isset(System::request()->post['userauth_email_address']) && isset(System::request()->post['userauth_password']) ) {
			$this->login(System::request()->post['userauth_email_address'], System::request()->post['userauth_password']);
		}

		if ( isset(System::request()->post['userauth_logout']) || isset(System::request()->get['logout']) ) {
			$this->logout();
		}

		$this->updateSession();
	}

	public function logout() {
		$this->webauth = $this->_default_webauth;
		$this->updateSession();
	}

	public function login($user, $pass) {

		// Find user profile by username or email address
		// I created an artificial request called 'username_or_email'
		// The Messenger class will do an OR search on web_username and email
		$user_profile = System::Messenger()->webUser_profile_request(array(
			'username_or_email' => $user,
			'market_id' => System::Build()->info['market_id']
		));

		if ( $user_profile && (hash('md5', $pass . $user_profile['salt']) == $user_profile['password']) ) {
			$this->webauth['email_address'] = $user_profile['email_address'];
			$this->webauth['web_username'] = $user_profile['web_username'];
			$this->webauth['web_user_id'] = $user_profile['web_user_id'];

			// Added for getting personal information
			$this->webauth['party_id'] = $user_profile['party_id'];

			$this->webauth['user_status'] = 'logged';
			$this->webauth['user_info'] = array();
			$user_access = System::Messenger()->webUser_access_request($params = array('web_user_id' => $this->webauth['web_user_id']));

			$this->webauth['user_info']['access'] = array();
			foreach ( $user_access as $ua_index => $access_info ) {
				$this->webauth['user_info']['access'][$access_info['module_name']] = $access_info;
			}
			$this->updateSession();
		}
	}

	public function updateSession() {
		$this->webauth['last_activity_datetime'] = $this->_default_webauth['last_activity_datetime'];
		$this->webauth['expiration_datetime'] = $this->_default_webauth['expiration_datetime'];

		$this->status = $this->webauth['user_status'];

		/**
		 * For getting info from PARTY table.
		 */
		if ( $this->status == 'logged' ) {
			$this->webauth['party_info'] = array();
			$user_ac_info = System::Messenger()->webUser_edit_profile_request($params = array('web_user_id' => $this->webauth['web_user_id']));
			foreach ( $user_ac_info as $ua_index => $a_info ) {
				$this->webauth['ac_info'] = $a_info;
			}
		}

		//Debug::output($this->webauth->getArrayCopy());

		System::Messenger()->webUser_session_update($this->webauth->getArrayCopy());

		System::request()->cookie->set(array(
			'name' => $this->_cookie_name,
			'value' => $this->webauth['said'],
			'expire' => '+1 year'
		));
	}

	public function isLogged() {
		if ( $this->status == 'logged' ) {
			return true;
		} else {
			return false;
		}
	}

	public function getUser() {
		return $this->webauth;
	}

	public function checkAccess($access_module, $access_level, $limit = null) {
		return true;
		if ( isset($this->webauth['user_info']['access'][$access_module]) ) {

			switch ( $access_level ) {

				case 'view':
					if ( $this->webauth['user_info']['access'][$access_module]['has_view_access'] ) {
						return true;
					}
					break;

				case 'edit':
					if ( $this->webauth['user_info']['access'][$access_module]['has_edit_access'] ) {
						return true;
					}
					break;

				case 'create':
					if ( $this->webauth['user_info']['access'][$access_module]['has_create_access'] ) {
						return true;
					}
					break;

				case 'approve':
					if ( $this->webauth['user_info']['access'][$access_module]['has_approve_access'] ) {
						return true;
					}
					break;

				case 'publish':
					if ( $this->webauth['user_info']['access'][$access_module]['has_publish_access'] ) {
						return true;
					}
					break;

				case 'limited':

					switch ( $limit ) {

						case 'market':
							if ( $this->webauth['user_info']['access'][$access_module]['limited_to_market_id'] ) {
								return $this->webauth['user_info']['access'][$access_module];
							}
							break;

						case 'domain':
							if ( $this->webauth['user_info']['access'][$access_module]['limited_to_domain_id'] ) {
								return true;
							}
							break;

						case 'group':
							if ( $this->webauth['user_info']['access'][$access_module]['limited_to_group_id'] ) {
								return true;
							}
							break;

						case 'owner':
							if ( $this->webauth['user_info']['access'][$access_module]['owner_id'] ) {
								return true;
							}
							break;
					}
					break;
			}
		}

		return false;
	}
}