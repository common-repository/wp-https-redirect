<?php
// Prevent direct access to this file.
if( !defined( 'ABSPATH' ) ) {
	exit( 'You are not allowed to access this file directly.' );
}

define('WP_HTTPS_REDIRECT' , true);
if(defined('WP_HTTPS_REDIRECT')){
	add_action('template_redirect', 'wp_https_redirect');	
}

function wp_https_redirect(){

	if ( WP_HTTPS_REDIRECT && !is_ssl () )
	{
		wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301 );
	  	exit();
	}
}
