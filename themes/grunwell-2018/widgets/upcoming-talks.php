<?php

use SteveGrunwellCom\Talks as Talks;

class Grunwell_Upcoming_Talks extends WP_Widget {

	function __construct() {
		parent::__construct( 'widget_grunwell_upcoming_talks', __('Upcoming Talks', 'grunwell-2018'), [
			'classname'   => 'Widget_Grunwell_Upcoming_Talks',
			'description' => __('Displays upcoming talks.', 'grunwell-2018' ),
		] );
	}

	function widget( $args, $instance ) {
		$upcoming_talks = new WP_Query( [
			'post_type'      => 'grunwell_talk',
			'posts_per_page' => $instance['number_of_posts'],
			'post_status'    => 'publish',
			'meta_query'     => [
				[
					'key'     => 'event_date',
					'value'   => date('Y-m-d'),
					'compare' => '>',
					'type'    => 'date',
				],
			],
			'orderby'        => 'meta_value',
			'order'          => 'asc',
		] );

		echo $args['before_widget'];

		if ( ! empty( $instance['widget_title'] ) ) {
			echo $args['before_title'] . esc_html( apply_filters( 'widget_title', $instance['widget_title'] ) ) . $args['after_title'];
		}
?>

	<?php if ( $upcoming_talks->have_posts() ) : ?>

		<ul class="lovecraft-widget-list">
			<?php while( $upcoming_talks->have_posts() ) : $upcoming_talks->the_post(); ?>

				<li>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<div class="post-icon">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</div>
						<div class="inner">
							<p class="title"><?php the_title(); ?></p>
							<p class="meta"><?php echo esc_html(Talks\get_the_talk_date()); ?></p>
						</div>
					</a>
				</li>

			<?php endwhile; ?>
		</ul>

	<?php else: ?>

		<div class="textwidget">
			<p><?php echo wp_kses_post( sprintf(
				__( 'I don\'t currently have any upcoming talks scheduled, but please <a href="%s">get in touch</a> if you\'d like to set something up!', 'grunwell-2018' ),
				site_url( '/contact' )
			) ); ?></p>
		</div>

	<?php endif; ?>

	<p class="post-content">
		<a href="<?php echo get_post_type_archive_link( 'grunwell_talk' ); ?>" class="more-link"><?php esc_html_e( 'See all talks', 'grunwell-2018' ); ?></a>
	</p>
<?php
		echo $args['after_widget'];
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['widget_title'] = strip_tags( $new_instance['widget_title'] );
		// make sure we are getting a number
		$instance['number_of_posts'] = is_int( intval( $new_instance['number_of_posts'] ) ) ? intval( $new_instance['number_of_posts']): 5;

		//update and save the widget
		return $instance;

	}

	function form($instance) {
		$instance = wp_parse_args( $instance, [
			'widget_title'    => '',
			'number_of_posts' => 5,
		] );
?>

	<p>
		<label for="<?php echo $this->get_field_id( 'widget_title' ); ?>"><?php esc_html_e( 'Title', 'grunwell-2018' ); ?>:
		<input id="<?php echo $this->get_field_id( 'widget_title' ); ?>" name="<?php echo $this->get_field_name( 'widget_title' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $instance['widget_title'] ); ?>" /></label>
	</p>

	<p>
		<label for="<?php echo $this->get_field_id('number_of_posts'); ?>"><?php esc_html_e( 'Number of posts to display', 'grunwell-2018' ); ?>:
		<input id="<?php echo $this->get_field_id( 'number_of_posts' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $instance['number_of_posts'] ); ?>" /></label>
		<small><?php esc_html_e('(Defaults to 5 if empty)', 'grunwell-2018' ); ?></small>
	</p>

<?php
	}
}

register_widget( 'Grunwell_Upcoming_Talks' );
