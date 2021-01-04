<?php

/**
 * Overrides for Lovecraft.
 *
 * Note that this file is intentionally in the global namespace.
 */

/**
 * Override the post meta display.
 */
function lovecraft_post_meta() {
?>

	<div class="post-meta">
		<?php if ( 'grunwell_talk' === get_post_type() ) : ?>
			<?php get_template_part( 'template-parts/talk', 'date' ); ?>
		<?php else : ?>
			<p class="post-date"><?php the_time( get_option( 'date_format' ) ); ?></p>
		<?php endif; ?>

		<?php if ( has_category() ) : ?>
			<p class="post-categories"><span><?php _e( 'In', 'lovecraft' ); ?> </span><?php the_category( ', ' ); ?></p>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'lovecraft' ), '<p>', '</p>' ); ?>
	</div><!-- .post-meta -->

<?php
}
