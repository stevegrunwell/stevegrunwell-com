<?php

// Generate a unique suffix for IDs.
$unique = uniqid();
?>

<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="search-<?php echo esc_attr( $unique ); ?>" class="screen-reader-text">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr( _x('Search&hellip;', 'search form placeholder', 'grunwell-2018') ); ?>" name="s" id="search-<?php echo esc_attr( $unique ); ?>" />
	<button type="submit" class="search-button" aria-label="<?php esc_attr_e( 'Submit search form', 'grunwell-2018' ); ?>"><div class="genericon genericon-search"></button>
</form>
