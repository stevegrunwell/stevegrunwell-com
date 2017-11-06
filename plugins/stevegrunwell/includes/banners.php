<?php
/**
 * Banners in place of post thumbnails for single posts.
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom\Banners;

/**
 * Enqueue the scripting for the media selector.
 */
function enqueue_script( $screen ) {
	if ( ! in_array( $screen, [ 'post.php', 'post-new.php' ], true ) ) {
		//return;
	}

	wp_enqueue_media();
	wp_enqueue_script(
		'grunwell_banner',
		GRUNWELL_PLUGIN_URL . '/assets/banners.js',
		[ 'jquery' ],
		null,
		true
	);
}
add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_script' );

/**
 * Register the banner meta box.
 */
function register_meta_boxes() {
	add_meta_box(
		'grunwell-banner',
		_x( 'Banner', 'meta box title', 'stevegrunwell' ),
		__NAMESPACE__ . '\render_meta_box',
		get_post_types_by_support( 'thumbnail' ),
		'side',
		null
	);
}
add_action( 'add_meta_boxes', __NAMESPACE__ . '\register_meta_boxes' );

/**
 * Render the contents of the meta box.
 *
 * @param WP_Post $post The current post object.
 */
function render_meta_box( $post ) {
	$attachment_id = get_post_meta( $post->ID, 'grunwell_banner_id', true );
?>

	<div class="grunwell-image-input <?php echo $attachment_id ? 'has-image' : ''; ?>">
		<div class="image-div">
			<?php echo wp_get_attachment_image( $attachment_id, 'medium', false ); ?>
		</div>

		<p class="image-controls">
			<input type="button" class="button new" value="<?php echo esc_attr( _x( 'Select Image', 'image selection button text', 'stevegrunwell' ) ); ?>" />
			<input type="button" class="image-remove button" value="<?php echo esc_attr( _x( 'Remove Image', 'remove the currently-selected image', 'stevegrunwell' ) ); ?>" />
		</p>
		<input name="grunwell_banner_id" type="hidden" class="image-id" value="<?php echo esc_attr( $attachment_id ); ?>" />
	</div>
<?php
	wp_nonce_field( 'grunwell_banner_id', 'grunwell_nonce' );
}

/**
 * Save the meta box content on save_post_photo.
 *
 * Note that the photo caption will not be saved here, as we're using native handlers to save that
 * field directly into post_content.
 *
 * @param int $post_id The post ID.
 */
function save_post( $post_id ) {
	if (
		defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
		|| ! isset( $_POST['grunwell_nonce'], $_POST['grunwell_banner_id'] )
		|| ! wp_verify_nonce( $_POST['grunwell_nonce'], 'grunwell_banner_id' )
	) {
		return;
	}

	update_post_meta( $post_id, 'grunwell_banner_id', (int) $_POST['grunwell_banner_id'] );
}
add_action( 'save_post', __NAMESPACE__ . '\save_post' );
