<?php
/**
 * Exception for 413 Request Entity Too Large responses
 *
 * @package Requests
 */

/**
 * Exception for 413 Request Entity Too Large responses
 *
 * @package Requests
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Requests_Exception_HTTP_413 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 413;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Request Entity Too Large';
}