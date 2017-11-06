<?php
use SteveGrunwellCom\Talks as Talks;

get_header(); ?>

<div class="wrapper section">

	<div class="section-inner">

		<div class="content">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class('single post'); ?>>

					<div class="post-inner">

						<div class="post-header">

						    <h1 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

						    <div class="post-meta">
								<?php get_template_part( 'template-parts/talk', 'date' ); ?>
								<?php if (has_category()) : ?>
									<p class="post-categories"><span><?php _e('In','lovecraft'); ?> </span><?php the_category(', '); ?></p>
								<?php endif; ?>
								<?php edit_post_link('Edit', '<p>', '</p>'); ?>

						    </div>

						</div> <!-- /post-header -->

						<?php if ( get_the_content() ) : ?>

							<div class="post-content">

								<?php the_content(); ?>

								<?php
									$event = [
										'name'     => get_post_meta( get_the_ID(), 'event_name', true ),
										'url'      => get_post_meta( get_the_ID(), 'event_url', true ),
										'date'     => get_post_meta( get_the_ID(), 'event_date', true ),
										'date_end' => get_post_meta( get_the_ID(), 'event_date_end', true ),
										'venue'    => get_post_meta( get_the_ID(), 'venue', true ),
									];
								?>

								<?php if ( $event['name'] && $event['date'] ) : ?>
									<div class="event-details">
										<h2><?php esc_html_e( 'Event details', 'grunwell-2017' ); ?></h2>
										<p>
											<?php if ( $event['url'] ) : ?>
												<strong><a href="<?php echo esc_url( $event['url'] ); ?>" rel="external"><?php echo esc_html( $event['name'] ); ?></a></strong>
											<?php else : ?>
												<strong><?php echo esc_html( $event['name'] ); ?></strong>
											<?php endif; ?>
											<?php echo nl2br( PHP_EOL . esc_html( $event['venue'] ) ); ?>
											<span class="event-dates"><?php echo esc_html( Talks\get_the_talk_date() ); ?></span>
										</p>
									</div>
								<?php endif; ?>

							</div>

							<div class="clear"></div>

						<?php endif; ?>

						<?php if ( has_tag() ) : ?>

							<div class="post-tags">

								<?php the_tags('',''); ?>

							</div>

						<?php endif; ?>

					</div> <!-- /post-inner -->

					<?php
						$prev_post = get_previous_post();
						$next_post = get_next_post();
					?>

					<div class="post-navigation">

						<div class="post-navigation-inner">

							<?php
							if (!empty( $prev_post )): ?>

								<div class="post-nav-prev">
									<p><?php _e('Previous', 'lovecraft'); ?></p>
									<h4>
										<a href="<?php echo get_permalink( $prev_post->ID ); ?>" title="<?php _e('Previous post', 'lovecraft'); echo ': ' . esc_attr( get_the_title($prev_post) ); ?>">
											<?php echo get_the_title($prev_post); ?>
										</a>
									</h4>
								</div>
							<?php endif; ?>

							<?php
							if (!empty( $next_post )): ?>

								<div class="post-nav-next">
									<p><?php _e('Next', 'lovecraft'); ?></p>
									<h4>
										<a title="<?php _e('Next post', 'lovecraft'); echo ': ' . esc_attr( get_the_title($next_post) ); ?>" href="<?php echo get_permalink( $next_post->ID ); ?>">
											<?php echo get_the_title($next_post); ?>
										</a>
									</h4>
								</div>

							<?php endif; ?>

							<div class="clear"></div>

						</div> <!-- /post-navigation-inner -->

					</div> <!-- /post-navigation -->

					<?php comments_template( '', true ); ?>

				</div> <!-- /post -->

		   	<?php endwhile; else: ?>

				<p><?php _e("We couldn't find any posts that matched your query. Please try again.", "lovecraft"); ?></p>

			<?php endif; ?>

		</div> <!-- /content -->

		<?php get_sidebar(); ?>

		<div class="clear"></div>

	</div>

</div> <!-- /wrapper -->

<?php get_footer(); ?>
