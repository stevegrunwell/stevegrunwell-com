		</main><!-- #site-content -->

		<?php if ( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) : ?>

			<footer class="footer section big-padding bg-white">
				<div class="section-inner group">

					<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
						<div class="widgets"><?php dynamic_sidebar( 'footer-one' ); ?></div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
						<div class="widgets"><?php dynamic_sidebar( 'footer-two' ); ?></div>
					<?php endif; ?>

					<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
						<div class="widgets"><?php dynamic_sidebar( 'footer-three' ); ?></div>
					<?php endif; ?>

				</div><!-- .section-inner -->
			</footer><!-- .footer.section -->

		<?php endif; ?>

		<div class="credits section bg-dark">

			<div class="credits-inner section-inner">

				<p>Be excellent to each other.</p>

			</div><!-- .section-inner -->

		</div><!-- .credits.section -->

		<?php wp_footer(); ?>

	</body>
</html>
