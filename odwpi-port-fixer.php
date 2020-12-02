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
	add_filter('wp_normalize_site_data', 'correct_new_site_data');
}

/**
 * Correct New Site Data when instance is listening on a different port
 *
 * @param  mixed $data
 * @return void
 */
function correct_new_site_data( $data ){
	$port = getenv('WEB_PORT');

	if( ! empty( $port ) ){
		$domain = str_replace( $port, '', $data['domain']);

		$data['domain'] = "$domain:$port";
	}
	
	return $data;

}
