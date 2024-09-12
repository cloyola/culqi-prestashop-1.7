<?php
/**
 * Exception for 416 Requested Range Not Satisfiable responses
 *
 * @package Requests
 */

/**
 * Exception for 416 Requested Range Not Satisfiable responses
 *
 * @package Requests
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Requests_Exception_HTTP_416 extends Requests_Exception_HTTP {
	/**
	 * HTTP status code
	 *
	 * @var integer
	 */
	protected $code = 416;

	/**
	 * Reason phrase
	 *
	 * @var string
	 */
	protected $reason = 'Requested Range Not Satisfiable';
}