<?php
$form_id = uniqid( 'search-form-' );
$fieldid = uniqid( 's-' );
?>

<form method="get" class="search-form" id="<?php echo esc_attr( $form_id ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $fieldid ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search this site:', 'grunwell-2018' ); ?></label>
	<input type="search" class="search-field" placeholder="<?php _x( 'Search&hellip;', 'search form placeholder', 'grunwell-2018' ); ?>" name="s" id="<?php echo esc_attr( $fieldid ); ?>" />
	<button type="submit" class="search-button"><div class="genericon genericon-search"></div><span class="screen-reader-text"><?php _e( 'Search', 'lovecraft' ); ?></span></button>
</form>
