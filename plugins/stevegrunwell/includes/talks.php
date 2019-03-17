<?php
/**
 * Definition and functionality for the grunwell_talk custom post type.
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom\Talks;

use SteveGrunwellCom\Utils as Utils;

/**
 * Register the "Talks" custom post type.
 */
function register_talks_post_type() {
	register_post_type( 'grunwell_talk', array(
		'label'                => __( 'Talks', 'stevegrunwell' ),
		'labels'               => array(
			'singular_name'         => __( 'Talk', 'stevegrunwell' ),
			'add_new_item'          => __( 'Add New Talk', 'stevegrunwell' ),
			'edit_item'             => __( 'Edit Talk', 'stevegrunwell' ),
			'new_item'              => __( 'New Talk', 'stevegrunwell' ),
			'view_item'             => __( 'View Talk', 'stevegrunwell' ),
			'search_items'          => __( 'Search Talks', 'stevegrunwell' ),
			'not_found'             => __( 'No talks found', 'stevegrunwell' ),
			'not_found_in_trash'    => __( 'No talks found in trash', 'stevegrunwell' ),
			'all_items'             => __( 'All Talks', 'stevegrunwell' ),
			'archives'              => __( 'Talk Archives', 'stevegrunwell' ),
			'insert_into_item'      => __( 'Insert into talk', 'stevegrunwell' ),
			'uploaded_to_this_item' => __( 'Uploaded to this talk', 'stevegrunwell' ),
		),
		'description'          => __( 'Speeches, presentations, and conference talks.', 'stevegrunwell' ),
		'public'               => true,
		'menu_icon'            => 'dashicons-megaphone',
		'hierarchical'         => false,
		'supports'             => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'register_meta_box_cb' => __NAMESPACE__ . '\register_meta_box_cb',
		'taxonomies'           => array( 'post_tag' ),
		'has_archive'          => true,
		'rewrite'              => array(
			'slug'       => 'speaking',
			'with_front' => false,
		),
		'show_in_rest'         => true,
		'rest_base'            => 'speaking',
	) );
}
add_action( 'init', __NAMESPACE__ . '\register_talks_post_type' );

/**
 * Callback to register the post type's meta box.
 *
 * @param WP_Post $post The current post object.
 */
function register_meta_box_cb( $post ) {
	add_meta_box(
		'grunwell_event_meta',
		__( 'Event Details', 'stevegrunwell' ),
		__NAMESPACE__ . '\event_details_meta_cb',
		$post->post_type,
		'side'
	);
}

/**
 * Display the "Event Details" meta box.
 *
 * @param WP_Post $post The current post object.
 */
function event_details_meta_cb( $post ) {
	$name       = get_post_meta( $post->ID, 'event_name', true );
	$url        = get_post_meta( $post->ID, 'event_url', true );
	$venue      = get_post_meta( $post->ID, 'venue', true );
	$start_date = get_post_meta( $post->ID, 'event_date', true );
	$end_date   = get_post_meta( $post->ID, 'event_date_end', true );
	$canceled   = (bool) get_post_meta( $post->ID, 'event_canceled', true );
?>

	<p>
		<label for="grunwell-event-name"><?php esc_html_e( 'Event Name', 'stevegrunwell' ); ?></label><br>
		<input name="grunwell_event[event_name]" id="grunwell-event-name" type="text" class="large-text" value="<?php echo esc_attr( $name ); ?>" />
	</p>
	<p>
		<label for="grunwell-event-url"><?php esc_html_e( 'Event URL', 'stevegrunwell' ); ?></label><br>
		<input name="grunwell_event[event_url]" id="grunwell-event-url" type="url" class="large-text code" value="<?php echo esc_url( $url ); ?>" />
	</p>
	<p>
		<label for="grunwell-event-venue"><?php esc_html_e( 'Venue', 'stevegrunwell' ); ?></label><br>
		<textarea name="grunwell_event[venue]" id="grunwell-event-venue" class="large-text" rows="6"><?php echo esc_html( $venue ); ?></textarea>
	</p>

	<fieldset>
		<legend><?php esc_html_e( 'Dates', 'stevegrunwell' ); ?></legend>
		<p>
			<label for="grunwell-event-start-date"><?php esc_html_e( 'Start Date', 'stevegrunwell' ); ?></label><br>
			<input name="grunwell_event[event_date]" id="grunwell-event-start-date" type="date" value="<?php echo esc_attr( $start_date ); ?>" />
		</p>
		<p>
			<label for="grunwell-event-end-date"><?php esc_html_e( 'End Date', 'stevegrunwell' ); ?></label><br>
			<input name="grunwell_event[event_date_end]" id="grunwell-event-end-date" type="date" value="<?php echo esc_attr( $end_date ); ?>" />
		</p>
	</fieldset>

	<p>
		<label for="grunwell-event-canceled">
			<input name="grunwell_event[event_canceled]" id="grunwell-event-canceled" type="checkbox" <?php checked( $canceled, true ); ?>>
			<?php esc_html_e( 'Has this event been canceled?', 'grunwell-2018' ); ?>
		</label>
	</p>

<?php
	wp_nonce_field( 'grunwell-event-details', '_grunwell_event_details' );
}

/**
 * Callback to save event details.
 *
 * @param int $post_id The post ID being saved.
 */
function save_event_details( $post_id ) {
	if ( ! isset( $_POST['_grunwell_event_details'], $_POST['grunwell_event'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( $_POST['_grunwell_event_details'], 'grunwell-event-details' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$args = wp_parse_args( $_POST['grunwell_event'], array(
		'event_name'      => null,
		'event_url'       => null,
		'event_date'      => null,
		'event_date_end'  => null,
		'venue'           => null,
		'event_canceled'  => false,
	) );

	// Handle date validation.
	foreach ( array( 'event_date', 'event_date_end' ) as $key ) {
		$time = strtotime( $args[ $key ] );
		$date = $time ? date( 'Y-m-d', $time ) : null;

		update_post_meta( $post_id, $key, $date );
		unset( $args[ $key ] );
	}

	// Event URL.
	update_post_meta( $post_id, 'event_url', filter_var( $args['event_url'], FILTER_SANITIZE_URL ) );
	unset( $args['event_url'] );

	// Everything else will get sanitize_text_field().
	foreach ( $args as $key => $val ) {
		update_post_meta( $post_id, $key, sanitize_text_field( $val ) );
	}
}
add_action( 'save_post_grunwell_talk', __NAMESPACE__ . '\save_event_details' );

/**
 * Add custom columns to the post list.
 *
 * @param array $columns Currently-registered columns.
 * @return array The filtered $columns array.
 */
function manage_posts_columns( $columns ) {
	return Utils\array_merge_after_key( $columns, array(
		'event' => __( 'Event', 'stevegrunwell' ),
	), 'title' );
}
add_filter( 'manage_grunwell_talk_posts_columns' , __NAMESPACE__ . '\manage_posts_columns' );

/**
 * Handle the output of the custom "event" column in the post list.
 *
 * @param string $column  The current column.
 * @param int    $post_id The post ID.
 */
function manage_custom_column( $column, $post_id ) {
	switch ( $column ) {

		case 'event':
			$event_name = get_post_meta( $post_id, 'event_name', true );
			$event_url  = get_post_meta( $post_id, 'event_url', true );

			if ( $event_name ) {
				if ( $event_url ) {
					printf( '<a href="%s">%s</a>', esc_attr( $event_url ),	esc_html( $event_name ) );
				} else {
					echo esc_html( $event_name );
				}
			} else {
				echo esc_html( _x( '–', 'indicates empty column', 'stevegrunwell' ) );
			}
			echo '<br>' . esc_html( get_the_talk_date() );
			break;

	}
}
add_action( 'manage_grunwell_talk_posts_custom_column' , __NAMESPACE__ . '\manage_custom_column', 10, 2 );

/**
 * Retrieve a formatted date range for a given talk.
 *
 * @param int $post_id Optional. The post ID to display dates for. Default is the current post.
 */
function get_the_talk_date( $post_id = 0, $inc_name = false ) {
	if ( ! $post_id ) {
		$post_id = get_the_ID();
	}

	$start_date  = strtotime( get_post_meta( $post_id, 'event_date', true ) );
	$end_date    = strtotime( get_post_meta( $post_id, 'event_date_end', true ) );
	$date_format = get_option( 'date_format' );

	// We need *at least* a start date.
	if ( ! $start_date ) {
		return;
	}

	// If the end date is the same as (or before) $start_date, disregard it.
	if ( date( 'Y-m-d', $start_date ) < date( 'Y-m-d', $end_date ) ) {

		// Determine the date range formatting.
		$start_year  = date( 'Y', $start_date );
		$start_month = date( 'm', $start_date );
		$end_year    = date( 'Y', $end_date );
		$end_month   = date( 'm', $end_date );

		// Different years.
		if ( $start_year !== $end_year ) {
			$date_range = sprintf(
				/** Translators: %1$s is the event start date, %2$s is the event end date. */
				_x( '%1$s – %2$s', 'event date range, two dates in two different years', 'stevegrunwell' ),
				date_i18n( $date_format, $start_date ),
				date_i18n( $date_format, $end_date )
			);

		// Different start months
		} elseif ( $start_month !== $end_month ) {
			$date_range = sprintf(
				/** Translators: %1$s is the event start date (month and day only), %2$s is the event end date. */
				_x( '%1$s – %2$s', 'event date range, two dates in the same year', 'stevegrunwell' ),
				date_i18n(
					_x( 'F j', 'PHP date format for just the month and day', 'stevegrunwell' ),
					$start_date
				),
				date_i18n( $date_format, $end_date )
			);

		} else {
			/** Translators: %1$s is the start date (month and day only), %2$s is the end date (day and year only). */
			$format = _x( '%1$s – %2$s', 'PHP date format for two days in the same month', 'stevegrunwell' );
			$start  = _x( 'F j', 'PHP date format for the start date in a date range for two dates in the same month', 'stevegrunwell' );
			$end    = _x( 'j, Y', 'PHP date format for the end date in a date range for two dates in the same month', 'stevegrunwell' );
			$date_range = sprintf( $format, date_i18n( $start, $start_date ), date_i18n( $end, $end_date ) );
		}

	// Either no end date was provided or its invalid.
	} else {
		$end_date = $start_date;
		$date_range = date_i18n( $date_format, $start_date );
	}

	return $date_range;
}

/**
 * When querying a tag archive, include the grunwell_talk custom post type.
 *
 * @param WP_Query $query
 */
function include_talks_in_taxonomy_queries( $query ) {
	if ( ! $query->is_main_query() ) {
		return;
	} elseif ( ! $query->is_tag() ) {
		return;
	}

	// Append "grunwell_talk" to the current list of post types.
	$post_types   = array_filter( (array) $query->get( 'post_type' ) );
	$post_types[] = 'grunwell_talk';

	$query->set( 'post_type', $post_types );
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\include_talks_in_taxonomy_queries' );

/**
 * Order the grunwell_talk post-type archive by the talk date.
 *
 * @param WP_Query $query
 */
function order_talks_by_date( $query ) {
	if ( ! $query->is_main_query() ) {
		return;
	} elseif ( ! $query->is_post_type_archive( 'grunwell_talk' ) ) {
		return;
	}

	$query->set('meta_key', 'event_date');
	$query->set('orderby', 'meta_value');
	$query->set('order', 'DESC');
	$query->set('meta_type', 'DATE');
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\order_talks_by_date' );
