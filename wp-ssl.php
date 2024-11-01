<?php
/*
	Plugin Name: WP HTTPS Redirect
	Plugin URI: 
	Description: Redirect all traffic from HTTP to HTTPS to all pages of your WordPress website.
	Stable Tag: 1.0.0
	Author: Ozvacatecleaning
	Author URI: https://ozvacatecleaning.com.au/
	Version: 1.0.0
*/

//
register_activation_hook( __FILE__, 'wphr_welcome_screen' );
function wphr_welcome_screen() {
	set_transient( '_welcome_screen_activation_redirect', true, 30 );
}

add_action( 'admin_init', 'wphr_welcome_screen_do_activ_redirect' );
function wphr_welcome_screen_do_activ_redirect() {
	
	// if no activ redirect
	if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
		return;
	}

	// Delete the redirect transient
	delete_transient( '_welcome_screen_activation_redirect' );

	// if activating from network, or bulk
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	// Redirect to welcome screen
	wp_safe_redirect( add_query_arg( array( 'page' => 'wphr-welcome-screen' ), admin_url( 'index.php' ) ) );
}

add_action('admin_menu', 'wpssl_welcome_screen_pages');
function wpssl_welcome_screen_pages() {
	add_dashboard_page(
	'Welcome to WP HTTPS Redirect',
	'Welcome to WP HTTPS Redirect',
	'read',
	'wphr-welcome-screen',
	'wphr_welcome_content'
	);
}

function wphr_welcome_content() {
?>
<div id="wpbody">
	<div id="wpbody-content">
		<div class="wrap about-wrap">
			<h1>Thank you for installing WP HTTPS Redirect!</h1>
			<div class="about-text">This plugin helps you redirect HTTP traffic to HTTPS without the need of touching any code.</div>
			<h3>Some things are required for this to happen:</h3>
			<ul class="ul-disc">
				<li>First you need to install SSL/HTTPS Certificate using Cpanel.</li>
				<li>You just need to set HTTPS URL in WordPress Address (URL) & Site Address (URL) under Setting-> General.</li> 
			</ul>
		</div>
	</div>
</div>

<?php
}

add_action( 'admin_head', 'wphr_remove_menus' );
function wphr_remove_menus() {
	remove_submenu_page( 'index.php', 'wphr-welcome-screen' );
}

// Prevent direct access to this file.
if( !defined( 'ABSPATH' ) ) {
	exit( 'You are not allowed to access this file directly.' );
}

// Check if PHP is at the minimum required version
if( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	define( 'WP_HTTPS_REDIRECT_FILE', __FILE__ );
	require_once dirname( __FILE__ ) . '/main.php';
} else {
	exit( 'Your PHP version is older then 5.4 Please Contact Your administrator.' );
}

?>