<?php

if ( is_day() ) {
	$headline = sprintf( __( 'Date: %s', 'lovecraft' ), '' . get_the_date( get_option('date_format') ) . '' );
} elseif ( is_month() ) {
	$headline = sprintf( __( 'Month: %s', 'lovecraft' ), '' . get_the_date('F Y') . '' );
} elseif ( is_year() ) {
	$headline = sprintf( __( 'Year: %s', 'lovecraft' ), '' . get_the_date( 'Y' ) . '' );
} elseif ( is_category() ) {
	$headline = sprintf( __( 'Category: %s', 'lovecraft' ), '' . single_cat_title( '', false ) . '' );
} elseif ( is_tag() ) {
	$headline = sprintf( __( 'Tag: %s', 'lovecraft' ), '' . single_tag_title( '', false ) . '' );
} else {
	$headline = false;
}

get_header(); ?>

<div class="wrapper section">

	<div class="section-inner">

		<div class="content">

			<?php if ( $headline ) : ?>
				<div class="page-title">
					<div class="section-inner">
						<h4><?php echo esc_html( $headline ); ?></h4>
					</div> <!-- /section-inner -->
				</div> <!-- /page-title -->
			<?php endif; ?>

			<?php if ( have_posts() ) : ?>

				<?php rewind_posts(); ?>

				<div class="posts" id="posts">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', get_post_format() ); ?>

					<?php endwhile; ?>

				</div> <!-- /posts -->

				<?php lovecraft_archive_navigation(); ?>

			<?php endif; ?>

		</div> <!-- /content -->

		<?php get_sidebar(); ?>

		<div class="clear"></div>

	</div> <!-- /section-inner -->

</div> <!-- /wrapper.section -->

<?php get_footer(); ?>
