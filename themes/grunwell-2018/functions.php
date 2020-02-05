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

	wp_enqueue_style(
		'grunwell_print',
		get_stylesheet_directory_uri() . '/print.css',
		[ 'grunwell_styles' ],
		null,
		'print'
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

/**
 * Inject taxonomy descriptions at the top of sidebars.
 *
 * @param string|int The sidebar index/name.
 */
function inject_taxonomy_description( $sidebar ) {
	if ( 'sidebar' !== $sidebar ) {
		return;
	}

	$description = '';

	if ( is_category() || is_tag() || is_tax() ) {
		$description = term_description();
	}

	if ( ! empty( $description ) ) {
		the_widget( 'WP_Widget_Text',
			[
				'title' => single_term_title( '', false ),
				'text'  => $description,
			],
			[
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
				'before_widget' => '<div class="widget widget_text"><div class="widget-content">',
				'after_widget' => '</div><div class="clear"></div></div>',
			]
		);
	}
}
add_action( 'dynamic_sidebar_before', __NAMESPACE__ . '\inject_taxonomy_description' );

/**
 * Inject banner images into the RSS feed.
 *
 * @param string $content The feed post content.
 *
 * @return string The (possibly) modified $content.
 */
function inject_banner_into_rss_content( $content ) {
	$banner_id = get_post_meta( get_the_ID(), 'grunwell_banner_id', true );

	return wp_get_attachment_image( $banner_id, 'post-image' ) . PHP_EOL . $content;
}
add_filter( 'the_excerpt_rss', __NAMESPACE__ . '\inject_banner_into_rss_content', 999 );
add_filter( 'the_content_feed', __NAMESPACE__ . '\inject_banner_into_rss_content', 999 );
