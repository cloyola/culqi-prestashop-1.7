<?php
/**
 * Exception for 428 Precondition Required responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */

/**
 * Exception for 428 Precondition Required responses
 *
 * @see https://tools.ietf.org/html/rfc6585
 * @package Requests
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Requests_Exception_HTTP_428 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 428;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Precondition Required';
}