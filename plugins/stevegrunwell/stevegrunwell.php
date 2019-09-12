<?php
/**
 * Plugin Name: SteveGrunwell.com
 * Plugin URI:  https://stevegrunwell.com
 * Description: Site functionality for SteveGrunwell.com.
 * Version:     0.1.0
 * Author:      Steve Grunwell
 * Author URI:  https://stevegrunwell.com
 * Text Domain: stevegrunwell
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom;

define( 'GRUNWELL_PLUGIN_URL', plugins_url( null, __FILE__ ) );

require_once __DIR__ . '/includes/affiliates.php';
require_once __DIR__ . '/includes/banners.php';
require_once __DIR__ . '/includes/presentations.php';
require_once __DIR__ . '/includes/utils.php';
require_once __DIR__ . '/includes/talks.php';

/**
 * Enqueue custom admin styles.
 */
function enqueue_script( $screen ) {
	wp_enqueue_style( 'grunwell', GRUNWELL_PLUGIN_URL . '/assets/admin.css' );
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );
