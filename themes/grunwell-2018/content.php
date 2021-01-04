<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<?php
	$post_format = get_post_format() ? get_post_format() : 'standard';
	$post_type = get_post_type();
	?>

	<?php if ( $banner_id = get_post_meta( get_the_ID(), 'grunwell_banner_id', true ) ) : ?>

		<figure class="post-image">
			<a href="<?php the_permalink(); ?>">
				<?php echo wp_get_attachment_image( $banner_id, 'post-image' ); ?>
			</a> <!-- .featured-media -->
		</figure><!-- .post-image -->

	<?php endif; ?>

	<div class="post-inner">

		<?php if ( $post_format !== 'aside' ) : ?>

			<div class="post-header">

				<?php if ( get_the_title() ) : ?>

					<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					<?php
				endif;

				if ( is_sticky() ) : ?>

					<a href="<?php the_permalink(); ?>" class="sticky-post">
						<div class="genericon genericon-star"></div>
						<span class="screen-reader-text"><?php _e( 'Sticky post', 'lovecraft' ) ?></span>
					</a>

					<?php
				endif;

				lovecraft_post_meta();

				?>

			</div><!-- .post-header -->

		<?php endif; ?>

		<?php if ( get_the_content() ) : ?>

			<div class="post-content entry-content">
				<?php the_excerpt(); ?>

				<p><a href="<?php the_permalink(); ?>" class="more-link faux-button"><?php esc_html_e( 'Continue reading&rarr;', 'grunwell-2018' ); ?></a></p>
			</div>

			<?php
		endif;

		?>

	</div><!-- .post-inner -->

</div><!-- .post -->
