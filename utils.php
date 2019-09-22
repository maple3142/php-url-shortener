<?php
function generateRandomString($length = 15)
{
	$chs = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chslen = strlen($chs);
	$str = '';
	for ($i = 0; $i < $length; $i++) {
		$str .= $chs[rand(0, $chslen - 1)];
	}
	return $str;
}
function get_base_url()
{
	$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
	$protocol = $is_https ? 'https' : 'http';
	$host = $_SERVER['HTTP_HOST'];
	return $protocol . '://' . $host;
}
function encodeURI($url)
{
	// Like javascript's encodeURI instead of encodeURIComponent
	// http://php.net/manual/en/function.rawurlencode.php
	// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI
	$unescaped = array(
		'%2D' => '-', '%5F' => '_', '%2E' => '.', '%21' => '!', '%7E' => '~',
		'%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')'
	);
	$reserved = array(
		'%3B' => ';', '%2C' => ',', '%2F' => '/', '%3F' => '?', '%3A' => ':',
		'%40' => '@', '%26' => '&', '%3D' => '=', '%2B' => '+', '%24' => '$'
	);
	$score = array(
		'%23' => '#'
	);
	return strtr(rawurlencode($url), array_merge($reserved, $unescaped, $score));
}
