<?php if ( is_active_sidebar('footer-one') || is_active_sidebar('footer-two') || is_active_sidebar('footer-three') ) : ?>

	<div class="footer section big-padding bg-white">

		<div class="section-inner">

			<div class="widgets">

				<?php dynamic_sidebar('footer-one'); ?>

			</div>

			<div class="widgets">

				<?php dynamic_sidebar('footer-two'); ?>

			</div>

			<div class="widgets">

				<?php dynamic_sidebar('footer-three'); ?>

			</div>

			<div class="clear"></div>

		</div> <!-- /section-inner -->

	</div> <!-- /footer.section -->

<?php endif; ?>

<div class="credits section bg-dark">

	<div class="credits-inner section-inner">

		<p>Be excellent to each other.</p>

	</div> <!-- /section-inner -->

</div> <!-- /credits.section -->

<?php wp_footer(); ?>

</body>
</html>
