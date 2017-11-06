<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>

	<?php if ( $banner_id = get_post_meta( get_the_ID(), 'grunwell_banner_id', true ) ) : ?>

		<a class="post-image" title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>">

			<?php echo wp_get_attachment_image( $banner_id, 'post-image' ); ?>

		</a> <!-- /featured-media -->

	<?php endif; ?>

	<div class="post-inner">

		<div class="post-header">

			<?php if ( get_the_title() ) : ?>

			    <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

			<?php endif; ?>

			<?php if ( is_sticky() ) : ?>

				<a href="<?php the_permalink(); ?>" title="<?php _e('Sticky post','lovecraft') ?>" class="sticky-post">
					<div class="genericon genericon-star"></div>
				</a>

			<?php endif; ?>

		    <div class="post-meta">
				<?php if ( 'grunwell_talk' === get_post_type() ) : ?>
					<?php get_template_part( 'template-parts/talk', 'date' ); ?>
				<?php else : ?>
					<p class="post-date"><?php the_time(get_option('date_format')); ?></p>
				<?php endif; ?>
				<?php if (has_category()) : ?>
					<p class="post-categories"><span><?php _e('In','lovecraft'); ?> </span><?php the_category(', '); ?></p>
				<?php endif; ?>
				<?php edit_post_link('Edit', '<p>', '</p>'); ?>

		    </div>

		</div> <!-- /post-header -->

		<?php if ( get_the_excerpt() ) : ?>

			<div class="post-content">

				<?php the_excerpt(); ?>

				<p><a href="<?php the_permalink(); ?>" class="more-link"><?php esc_html_e( 'Continue reading&rarr;', 'grunwell-2017' ); ?></a></p>
			</div>

			<div class="clear"></div>

		<?php endif; ?>

	</div> <!-- /post-inner -->

</div> <!-- /post -->
