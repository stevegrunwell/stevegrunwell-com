<!DOCTYPE html>

<html class="no-js" <?php language_attributes(); ?>>

	<head profile="http://gmpg.org/xfn/11">

		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" >

		<?php wp_head(); ?>

	</head>

	<body <?php body_class(); ?>>

		<div class="header-wrapper">

			<div class="header section bg-white small-padding">

				<div class="section-inner">

					<?php if ( get_theme_mod( 'lovecraft_logo' ) ) : ?>

				        <a class="blog-logo" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>' rel='home'>
				        	<img src='<?php echo esc_url( get_theme_mod( 'lovecraft_logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'title' ) ); ?>'>
				        </a>

					<?php elseif ( get_bloginfo( 'description' ) || get_bloginfo( 'title' ) ) : ?>

						<h2 class="blog-title">
							<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'title' ) ); ?> &mdash; <?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" rel="home"><?php echo esc_attr( get_bloginfo( 'title' ) ); ?></a>
						</h2>

						<?php if ( get_bloginfo( 'description' ) ) : ?>

							<h4 class="blog-tagline">
								<?php bloginfo('description'); ?>
							</h4>

						<?php endif; ?>

					<?php endif; ?>

					<div class="clear"></div>

				</div> <!-- /section-inner -->

			</div> <!-- /header -->

			<div class="toggles">

				<div class="nav-toggle toggle">

					<div class="bar"></div>
					<div class="bar"></div>
					<div class="bar"></div>

				</div>

				<div class="search-toggle toggle">

					<div class="genericon genericon-search"></div>

				</div>

				<div class="clear"></div>

			</div> <!-- /toggles -->

		</div> <!-- /header-wrapper -->

		<div class="navigation bg-white no-padding">

			<div class="section-inner">

				<ul class="mobile-menu">

					<?php if ( has_nav_menu( 'primary' ) ) {

						wp_nav_menu( array(

							'container' => '',
							'items_wrap' => '%3$s',
							'theme_location' => 'primary'

						) ); } else {

						wp_list_pages( array(

							'container' => '',
							'title_li' => ''

						));

					} ?>

				</ul>

				<div class="mobile-search">

					<?php get_search_form(); ?>

				</div>

				<div class="clear"></div>

			</div> <!-- /section-inner -->

		</div> <!-- /navigation -->

		<?php if ( is_singular() && ( $banner_id = get_post_meta( get_the_ID(), 'grunwell_banner_id', true ) ) ) : ?>

			<?php $thumb = wp_get_attachment_image_src( $banner_id, 'post-image-cover' ); ?>

			<div class="header-image bg-image" style="background-image: url(<?php echo esc_url( $thumb['0'] ); ?>)">

				<?php echo wp_get_attachment_image( $banner_id, 'post-image' ); ?>

			</div>

		<?php else : ?>

			<div class="header-image bg-image" style="background-image: url(<?php if (get_header_image() != '') { header_image(); echo ')'; } else { echo   get_template_directory_uri() . "/images/header.jpg)"; } ?>">

				<?php
					if (get_header_image() != '') {
						echo '<img src="'; header_image(); echo '">';
					} else {
						echo '<img src="' . get_template_directory_uri() . '/images/header.jpg">';
					}
				?>

			</div>

		<?php endif; ?>
