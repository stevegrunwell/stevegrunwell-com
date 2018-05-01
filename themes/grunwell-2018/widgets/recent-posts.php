<?php

class Grunwell_Recent_Posts extends Lovecraft_Recent_Posts {

	function widget( $args, $instance ) {
		// Append a link to read all blog posts.
		$args['after_widget'] = '<p class="post-content">
			<a href="' . esc_url( get_home_url() ) . '" class="more-link">' . esc_html__( 'See all posts', 'grunwell-2018' ) . '</a></p>'
			. $args['after_widget'];

		parent::widget( $args, $instance );
	}
}

unregister_widget( 'Lovecraft_Recent_Posts' );
register_widget( 'Grunwell_Recent_Posts' );
