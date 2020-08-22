<?php

/**
 * Plugin Name: Use Hashtags
 * Plugin URI: https://gruhh.com/en/projects/wordpress-plugin-use-hashtags/
 * Description: Convert all the #hashtags in your content and excerpts to a search link.
 * Version: 1.0.1
 * Author: gruhh
 * Author URI: https://gruhh.com/
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: use-hashtags
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load the admin panel when in admin mode
if ( is_admin() ) {
	require_once __DIR__ . '/admin/use-hashtags-admin.php';
}

/**
 * Activate the plugin.
 */
function use_hashtags_activate() {
	// Create the default options
	$data_r = [
		'use_hashtags_link'         => '?s=',
		'use_hashtags_link_qualify' => 'nofollow',
		'use_hashtags_link_target'  => '',
		'use_hashtags_in_content'   => true,
		'use_hashtags_in_excerpt'   => false,
	];

	add_option( 'use_hashtags_options', $data_r );
}

register_activation_hook( __FILE__, 'use_hashtags_activate' );

/**
 * Uninstall the plugin.
 */
function use_hashtags_uninstall() {
	// Delete the options
	delete_option( 'use_hashtags_options' );
}

register_uninstall_hook( __FILE__, 'use_hashtags_uninstall' );

/**
 * Add a filter to use hashtags in the context of the_content.
 */
function use_hashtags_in_content( $content ) {
	$options_r = get_option( 'use_hashtags_options' );

	if ( $options_r['use_hashtags_in_content'] && in_the_loop() && is_main_query() ) {
		return use_hashtags_convert_hashtags_to_links( $content );
	}

	return $content;
}

add_filter( 'the_content', 'use_hashtags_in_content', 5, 1 );

/**
 * Add a filter to use hashtags in the context of the_excerpt.
 */
function use_hashtags_in_excerpt( $content ) {
	$options_r = get_option( 'use_hashtags_options' );

	if ( $options_r['use_hashtags_in_excerpt'] && in_the_loop() && is_main_query() ) {
		return use_hashtags_convert_hashtags_to_links( $content );
	}

	return $content;
}

add_filter( 'the_excerpt', 'use_hashtags_in_excerpt', 5, 1 );

/**
 * Search for hashtags and replace then with a link.
 */
function use_hashtags_convert_hashtags_to_links( $content ) {
	$options_r        = get_option( 'use_hashtags_options' );
	$regex            = "#(\w+)"; // [A-Za-z0-9_]
	$site_url         = home_url();
	$link             = $options_r['use_hashtags_link'];
	$link_qualify     = $options_r['use_hashtags_link_qualify'];
	$link_target      = $options_r['use_hashtags_link_target'];
	$prepared_options = ' class="hashtag-link"';

	// Qualify the link
	if ( ! empty( $link_qualify ) ) {
		$prepared_options .= " rel=\"{$link_qualify}\"";
	}

	// Target the link
	if ( ! empty( $link_target ) ) {
		$prepared_options .= " target=\"{$link_target}\"";
	}

	// Prepare the base href
	// %23 is the # symbol encoded
	$prepared_href = esc_url( $site_url . "/" . $link . "%23" );

	// Search and replace the hashtags with a link
	return preg_replace(
		"/{$regex}/",
		"<a href=\"{$prepared_href}$1\"{$prepared_options}>#$1</a>",
		$content
	);
}
