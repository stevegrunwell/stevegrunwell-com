<?php
/**
 * Definition and functionality for the grunwell_presentation custom taxonomy.
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom\Presentations;

use WP_Term;

/**
 * Register the "Presentations" taxonomy.
 */
function register_presentation_taxonomy() {
	register_taxonomy( 'grunwell_presentation', 'grunwell_talk', [
		'labels'             => [
    		'name'                       => __( 'Presentations', 'stevegrunwell' ),
		    'singular_name'              => __( 'Presentation', 'stevegrunwell' ),
		    'search_items'               => __( 'Search Presentations', 'stevegrunwell' ),
		    'popular_items'              => __( 'Popular Presentations', 'stevegrunwell' ),
		    'all_items'                  => __( 'All Presentations', 'stevegrunwell' ),
		    'edit_item'                  => __( 'Edit Presentation', 'stevegrunwell' ),
		    'view_item'                  => __( 'View Presentation', 'stevegrunwell' ),
		    'update_item'                => __( 'Update Presentation', 'stevegrunwell' ),
		    'add_new_item'               => __( 'Add New Presentation', 'stevegrunwell' ),
		    'new_item_name'              => __( 'New Presentation Name', 'stevegrunwell' ),
		    'separate_items_with_commas' => __( 'Separate presentations with commas', 'stevegrunwell' ),
		    'add_or_remove_items'        => __( 'Add or remove presentations', 'stevegrunwell' ),
		    'choose_from_most_used'      => __( 'Choose from the most used presentations', 'stevegrunwell' ),
		    'not_found'                  => __( 'No presentations found', 'stevegrunwell' ),
		    'no_terms'                   => __( 'No presentations', 'stevegrunwell' ),
		    'items_list_navigation'      => __( 'Presentations', 'stevegrunwell' ),
		    'items_list'                 => __( 'Presentations', 'stevegrunwell' ),
		    'back_to_items'              => __( 'Back to Presentations', 'stevegrunwell' ),
		],
		'description'        => __( 'Links to presentation decks.', 'stevegrunwell' ),
		'public'             => false,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_rest'       => false,
		'show_tagcloud'      => false,
		'show_in_quick_edit' => false,
		'show_admin_column'  => true,
	] );
}
add_action( 'init', __NAMESPACE__ . '\register_presentation_taxonomy' );

/**
 * Render the "URL" setting on the taxonomy term creation screen.
 *
 * @param \WP_Term $term The WP_Term object
 */
function render_add_url_field() {
?>

	<div class="form-field">
		<label for="presentation_url"><?php esc_html_e( 'Slides link', 'stevegrunwell' ); ?></label>
		<input name="presentation_url" id="presentation_url" type="url" />
		<p><?php esc_html_e( 'A link to the slides.', 'stevegrunwell' ); ?></p>
	</div>

<?php
}
add_action( 'grunwell_presentation_add_form_fields', __NAMESPACE__ . '\render_add_url_field' );

/**
 * Render the "URL" setting on the taxonomy term edit screen.
 *
 * @param \WP_Term $term The WP_Term object
 */
function render_edit_url_field( WP_Term $term ) {
	$url = get_term_meta( $term->term_id, 'presentation_url', true );
?>

	<tr class="form-field">
		<th scope="row" valign="top">
			<label for="presentation_url"><?php esc_html_e( 'Slides link', 'stevegrunwell' ); ?></label>
		</th>
		<td>
			<input name="presentation_url" id="presentation_url" type="url" value="<?php echo esc_attr( $url ); ?>" />
			<p class="description"><?php esc_html_e( 'A link to the slides.', 'stevegrunwell' ); ?></p>
		</td>
	</tr>

<?php
}
add_action( 'grunwell_presentation_edit_form_fields', __NAMESPACE__ . '\render_edit_url_field' );

/**
 * Save the URL value.
 *
 * @param int $term_id The term ID.
 */
function save_term_url( int $term_id ) {
	if ( ! isset( $_POST['presentation_url'] ) ) {
		return;
	}

	$value = sanitize_text_field( $_POST['presentation_url'] );

	if ( ! filter_var( $value, FILTER_VALIDATE_URL ) ) {
		//return;
	}

	update_term_meta( $term_id, 'presentation_url', $value );
}
add_action( 'edited_grunwell_presentation', __NAMESPACE__ . '\save_term_url' );
add_action( 'created_grunwell_presentation', __NAMESPACE__ . '\save_term_url' );
