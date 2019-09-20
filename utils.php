<?php
function generateRandomString($length = 10) {
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
