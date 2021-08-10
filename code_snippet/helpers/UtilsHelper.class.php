<?php
namespace YOUR_THEME_NAME\Helpers;

class UtilsHelper
{

	public static function get_the_user_ip()
	{
		$ip = '';
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	public static function redirect404()
	{
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		return \View::make('pages/404', []);
		exit();
	}

}
