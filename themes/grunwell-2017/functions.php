<?php
/**
 * Theme functions.
 */

namespace Grunwell2017;

/**
 * Enqueue the styles from the TwentySeventeen parent theme.
 */
function enqueue_parent_theme_styles() {
	wp_enqueue_style( 'lovecraft_style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_parent_theme_styles' );
