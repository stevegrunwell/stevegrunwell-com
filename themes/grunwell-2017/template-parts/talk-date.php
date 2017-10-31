<?php

use SteveGrunwellCom\Talks as Talks;

$event_name = get_post_meta( get_the_ID(), 'event_name', true );

if ( $event_name ) {
	$output = sprintf(
		/* Translators: %1$s is the event date, %2$s is the event name. */
		__( '%1$s @ %2$s', 'grunwell-2017' ),
		Talks\get_the_talk_date(),
		$event_name
	);
} else {
	$output = Talks\get_the_talk_date();
}

?>

<p class="post-date"><?php echo esc_html( $output ); ?></p>
