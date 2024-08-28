<?php
/*
Plugin Name: getUserInfo
Plugin URI: https://github.com/druffko/getUserInfo
Description: A simple plugin to enable showing the current users IP address and hostname. You can use the shortcode [show_ip] to view the users IP address or [show_hostname] to show the users hostname on any page.
Version: 1.0
Requires at least: 4.8
Tested up to: 5.5
Requires PHP: 5.6
Author: druffko
Author URI: https://druffko.gg
License: MIT

Copyright (c) 2024 druffko. All rights reserved.
*/

function gui_get_ip() {
	if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ip = $_SERVER['REMOTE_ADDR'];
}
	return apply_filters( 'wpb_get_ip', $ip );
}

function gui_get_hostname() {
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
}

function gui_get_os() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$os_platform = "Unknown OS";

	$os_array = array(
		'/windows nt 10/i'    => 'Windows 10',
		'/windows nt 6.3/i'    => 'Windows 8.1',
		'/windows nt 6.2/i'    => 'Windows 8',
		'/windows nt 6.1/i'    => 'Windows 7',
		'/windows nt 6.0/i'    => 'Windows Vista',
		'/windows nt 5.2/i'    => 'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'    => 'Windows XP',
		'/windows xp/i'        => 'Windows XP',
		'/windows nt 5.0/i'    => 'Windows 2000',
		'/windows me/i'        => 'Windows ME',
		'/win98/i'             => 'Windows 98',
		'/win95/i'             => 'Windows 95',
		'/win16/i'             => 'Windows 3.11',
		'/macintosh|mac os x/i' => 'Mac OS X',
		'/mac_powerpc/i'       => 'Mac OS 9',
		'/linux/i'             => 'Linux',
		'/ubuntu/i'            => 'Ubuntu',
		'/iphone/i'            => 'iPhone',
		'/ipod/i'              => 'iPod',
		'/ipad/i'              => 'iPad',
		'/android/i'           => 'Android',
		'/blackberry/i'        => 'BlackBerry',
		'/webos/i'             => 'Mobile',
	);

	foreach ($os_array as $regex => $value) {
		if (preg_match($regex, $user_agent)) {
			$os_platform = $value;
		}
	}

	return $os_platform;
}

function gui_get_device_type() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	if (strpos($user_agent, 'iPhone') !== false) {
		return 'iPhone';
	} elseif (strpos($user_agent, 'iPad') !== false) {
		return 'iPad';
	} elseif (strpos($user_agent, 'Android') !== false) {
		return 'Android';
	} elseif (strpos($user_agent, 'Windows Phone') !== false) {
		return 'Windows Phone';
	} elseif (strpos($user_agent, 'BlackBerry') !== false) {
		return 'BlackBerry';
	} elseif (strpos($user_agent, 'Macintosh') !== false) {
		return 'Macintosh';
	} elseif (strpos($user_agent, 'Windows') !== false) {
		return 'Windows PC';
	} elseif (strpos($user_agent, 'Linux') !== false) {
		return 'Linux PC';
	} else {
		return 'Unknown';
	}
}

function gui_get_browser() {
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	$browser = "Unknown";

	if (preg_match('/MSIE/i', $user_agent) && !preg_match('/Opera/i', $user_agent)) {
		$browser = 'Internet Explorer';
	} elseif (preg_match('/Firefox/i', $user_agent)) {
		$browser = 'Mozilla Firefox';
	} elseif (preg_match('/Chrome/i', $user_agent)) {
		$browser = 'Google Chrome';
	} elseif (preg_match('/Safari/i', $user_agent)) {
		$browser = 'Apple Safari';
	} elseif (preg_match('/Opera/i', $user_agent)) {
		$browser = 'Opera';
	} elseif (preg_match('/Netscape/i', $user_agent)) {
		$browser = 'Netscape';
	}

	return $browser;
}


add_shortcode('gui_show_ip', 'gui_get_ip');
add_shortcode('gui_show_hostname', 'gui_get_hostname');
add_shortcode('gui_show_os', 'gui_get_os');
add_shortcode('gui_show_device', 'gui_get_device_type');
add_shortcode('gui_show_browser', 'gui_get_browser');
	
?>