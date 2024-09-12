<?php
/**
 * Exception for 404 Not Found responses
 *
 * @package Requests
 */

/**
 * Exception for 404 Not Found responses
 *
 * @package Requests
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Requests_Exception_HTTP_404 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 404;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Not Found';
}