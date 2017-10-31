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
	wp_enqueue_style( 'lovecraft_style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_parent_theme_styles' );
