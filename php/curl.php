<?php

/**
 * Google URL Shortener API Example
 * Tom McFarlin / tom@tommcfarlin.com / January 15, 2010
 *
 * Simple demonstration of how to use the the Google URL API shortener.
 */
 
	/*------------------------------------------*/
	/* Constants
	/*------------------------------------------*/
	
	define('GOOGLE_URL', 'https://www.googleapis.com/urlshortener/v1/url');
	define('GOOGLE_API_KEY', 'YOUR_API_KEY_HERE');
	
	/*------------------------------------------*/
	/* Request Data
	/*------------------------------------------*/
	
	$longUrl = $_POST['longUrl'];
	$shortUrl = $_GET['shortUrl'];
	
	if(isset($longUrl)) {
		echo shorten($longUrl);
	} elseif(isset($shortUrl)) {
		echo expand($shortUrl);
	} else {
		echo 'You must enter a URL.';
	} // end if/else

	/*------------------------------------------*/
	/* API Functions
	/*------------------------------------------*/
	
	/**
	 * Shortens the incoming URL using the Google URL shortener API
	 * and returns the shortened version.
	 *
	 * @long_url	The URL to shorten.
	 */
	function shorten($long_url) {
		
		$ch = curl_init(GOOGLE_URL . '?key=' . GOOGLE_API_KEY);
		
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_TIMEOUT => 5,
				CURLOPT_CONNECTTIMEOUT => 0,
				CURLOPT_POST => 1,
				CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_POSTFIELDS => '{"longUrl": "' . $long_url . '"}'
			)
		);
		
		$json_response = json_decode(curl_exec($ch), true);
		return $json_response['id'] ? $json_response['id'] : $long_url;
		
	} // end shorten
	
	/**
	 * Expands the short URL using the Google shorten API.
	 *
	 * @short_url	The URL to expand.
	 */
	function expand($short_url) {
	
		$ch = curl_init(GOOGLE_URL . '?key=' . GOOGLE_API_KEY . '&shortUrl=' . $short_url);
		
		curl_setopt_array(
			$ch,
			array(
				CURLOPT_RETURNTRANSFER => 1,
				CURLOPT_TIMEOUT => 5,
				CURLOPT_CONNECTTIMEOUT => 0,
				CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0
			)
		);
		
		$json_response = json_decode(curl_exec($ch), true);
		return $json_response['longUrl'] ? $json_response['longUrl'] : $short_url;
	} // end expand
	
?>