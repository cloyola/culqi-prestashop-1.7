<?php
namespace Culqi;

if (!defined('_PS_VERSION_')) {
    exit;
}

use Culqi\Error as Errors;

/**
 * Class Client
 *
 * @package Culqi
 */
class Client {
	public function request( $method, $url, $api_key, $data = NULL, $secure_url = false ) {
		try {
			$url_params = is_array($data) ? '?' . http_build_query($data) : '';
			//var_dump($data);
			$headers = [
				'Authorization'		=> sprintf( 'Bearer %s', $api_key ),
				'Content-Type'		=> 'application/json',
				'Accept'			=> 'application/json',
				'Accept-Encoding'	=> '*',
			];
			//print_r($headers);
			
			$options = [ 'timeout' => 120 ]; 

			// TODO: We change to string to avoid the precision bug on PHP 7.1
			// URL : https://bugs.php.net/bug.php?id=72567
			if( is_array( $data ) && isset( $data['amount'] ) )
				$data['amount'] = strval( $data['amount'] );
			
			// Check URL
			//if($secure_url) $base_url = Culqi::SECURE_BASE_URL;
			//else $base_url = Culqi::BASE_URL;

			if($method == "GET") {

				update_option('kono_4', print_r($data['enviroment']. $url . $url_params,true));
				update_option('kono_7', print_r($headers,true));
				update_option('kono_8', print_r($options,true));

				$response = \Requests::get(Culqi::BASE_URL . $url . $url_params, $headers, $options);

				update_option('kono_9', print_r($response,true));

			} else if($method == "POST") {
				$response = \Requests::post($data['enviroment']  . $url, $headers, json_encode($data), $options);
				//echo var_dump($response);
			} else if($method == "PATCH") {
				$response = \Requests::patch($data['enviroment']  . $url, $headers, json_encode($data), $options);
			} else if($method == "DELETE") {
				$response = \Requests::delete($data['enviroment'] . $url . $url_params, $headers, $options);
			}
		} catch (\Exception $e) {
			throw new Errors\UnableToConnect();
		}
		if ($response->status_code >= 200 && $response->status_code <= 206) {
			return json_decode($response->body);
		}
		if ($response->status_code == 400) {
			throw new Errors\UnhandledError($response->body, $response->status_code);
		}
		if ($response->status_code == 401) {
			throw new Errors\AuthenticationError();
		}
		if ($response->status_code == 404) {
			throw new Errors\NotFound();
		}
		if ($response->status_code == 403) {
			throw new Errors\InvalidApiKey();
		}
		if ($response->status_code == 405) {
			throw new Errors\MethodNotAllowed();
		}
		throw new Errors\UnhandledError($response->body, $response->status_code);
	}
}
