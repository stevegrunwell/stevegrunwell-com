<?php

// Generate a unique suffix for IDs.
$unique = uniqid();
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-<?php echo esc_attr( $unique ); ?>" class="screen-reader-text"><?php esc_html_e( 'Search this site:', 'grunwell-2018' ); ?></label>
	<input type="search" class="search-field" placeholder="<?php echo esc_attr( _x('Search&hellip;', 'search form placeholder', 'grunwell-2018') ); ?>" name="s" id="search-<?php echo esc_attr( $unique ); ?>" />
	<button type="submit" class="search-button"><div class="genericon genericon-search"></div><span class="screen-reader-text"><?php _e( 'Search', 'grunwell-2018' ); ?></span></button>
</form>
