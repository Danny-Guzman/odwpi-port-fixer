<?php
/**
 * Plugin Name: Port Fixer
 * Plugin URI: "https://github.com/Danny-Guzman/odwpi-port-fixer/"
 * Description: A Plugin that will normalize site data allowing WordPress Multisite to run correctly when listening on ports other than 80/443.
 * Author: Danny Guzman
 * Version: 1.0.0
 * Author URI: "https://github.com/Danny-Guzman/"
 *
 * Network: true
 * 
 * @package PortFixer
 */

add_action( 'admin_init', 'port_fixer_admin_init' );

/**
 * Admin Init
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_init
 * @return void
 */
function port_fixer_admin_init() {
	/**
	 * This filter is fired during while Wordpress prepares the site data for insertion or update in the database.
	 * When WordPress is using a different port it removes the ':' from the domain which cause issues whenever the site domain is referenced. 
	 * @link https://core.trac.wordpress.org/browser/tags/5.5.1/src/wp-includes/ms-site.php#L498
	 * @link https://developer.wordpress.org/reference/functions/wp_normalize_site_data/
	 */
	add_filter('wp_normalize_site_data', 'correct_new_site_data');
}

/**
 * Normalize data for a site prior to inserting or updating in the database when using a different port.
 *
 * @param  array $data Associative array of site data passed to the respective function.
 * @return array
 */
function correct_new_site_data( $data ){
	$port = getenv('WEB_PORT');

	if( ! empty( $port ) ){
		$domain = str_replace( $port, '', $data['domain']);

		$data['domain'] = "$domain:$port";
	}
	
	return $data;

}
