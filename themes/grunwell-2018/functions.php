<?php
/**
 * Theme functions.
 */

namespace Grunwell2018;

define('LOVECRAFT_DIR', dirname( __DIR__ ) . '/lovecraft' );

require_once LOVECRAFT_DIR . '/widgets/recent-posts.php';
require_once __DIR__ . '/widgets/recent-posts.php';
require_once __DIR__ . '/widgets/upcoming-talks.php';

/**
 * Enqueue the styles from the parent theme.
 */
function enqueue_parent_theme_styles() {
	wp_dequeue_style( 'lovecraft_style' );
	wp_deregister_style( 'lovecraft_style' );
	wp_register_style(
		'lovecraft_style',
		get_template_directory_uri() . '/style.css',
		[
			'lovecraft_googlefonts',
			'lovecraft_genericons',
		]
	);

	wp_enqueue_style(
		'grunwell_styles',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'lovecraft_style' ]
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_parent_theme_styles', 100 );

/**
 * Remove post formats, as they won't be used.
 */
function remove_post_formats() {
	remove_theme_support( 'post-formats' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_post_formats', 11 );
