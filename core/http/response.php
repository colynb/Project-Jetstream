<?php

namespace jetstream\core\http;

use jetstream\core\debug\Debug;

class Response {
	/**
	 * Default Response Settings
	 */
	public $_settings = array(
		'version' => '1.0',
		'status_code' => '200',
		'status_text' => 'OK',
		'charset' => 'UTF-8',
		'headers' => array(
			'X-Powered-By' => 'jetstream Framework',
			'Content-Type' => 'text/html'
		),
	);

	/**
	 * Static library of HTTP status codes
	 * More Info: http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	 * @var type static array
	 */
	public static $status_texts = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot (RFC 2324)',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported'
	);

	public function __construct($content = '', $settings = array()) {
		$this->_settings = $settings + $this->_settings;
		$this->content = $content;
	}

	/**
	 * Render response headers
	 */
	public function sendHeaders() {

		header_remove('Pragma');

		// status
		header(sprintf('HTTP/%s %s %s', $this->_settings['version'], $this->_settings['status_code'], $this->_settings['status_text']));

		foreach ( $this->_settings['headers'] as $name => $value ) {
			header($name . ': ' . $value);
		}
	}

	public function setStatusCode($code) {
		$this->_settings['status_code'] = (int) $code;
		$this->_settings['status_text'] = self::$status_texts[$this->_settings['status_code']];
	}

	public function redirect($url) {
		debug::dump($url);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url");
	}

	public function setContentType($value) {
		$this->_settings['headers']['Content-Type'] = $value;
	}

	public function setContentExpiry($time) {
		$this->_settings['headers']['Expires'] = gmdate('D, d M Y H:i:s \G\M\T', strtotime($time));
		$this->_settings['headers']['Cache-Control'] = 'max-age=' . strtotime($time);
	}

	public function setContent($content) {
		$this->content = $content;
	}

	public function __toString() {
		$this->sendHeaders();
		return $this->content;
	}

	public function isError() {
		return ($this->_settings['status_code'] == '404') ? $this->_settings['status_code'] : false;
	}
}