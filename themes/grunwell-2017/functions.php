<?php
/**
 * Theme functions.
 */

namespace Grunwell2017;

define('LOVECRAFT_DIR', dirname( __DIR__ ) . '/lovecraft' );

require_once __DIR__ . '/widgets/upcoming-talks.php';

/**
 * Enqueue the styles from the parent theme.
 */
function enqueue_parent_theme_styles() {
	wp_register_style( 'lovecraft_style', get_template_directory_uri() . '/style.css' );

	wp_enqueue_style(
		'grunwell_styles',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'lovecraft_style' ]
	);
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_parent_theme_styles' );

/**
 * Remove post formats, as they won't be used.
 */
function remove_post_formats() {
	remove_theme_support( 'post-formats' );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\remove_post_formats', 11 );
