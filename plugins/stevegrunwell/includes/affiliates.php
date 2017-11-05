<?php
/**
 * Definition and functionality for the grunwell_talk custom post type.
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom\Affiliates;

/**
 * Get the affiliate disclosure markup.
 *
 * @return string
 */
function get_disclosure() {
	return <<<EOT
<!-- Affiliate disclosure -->
<aside class="affiliate-disclosure" role="Contentinfo">
	<p>Disclosure: Some of the links below are affiliate links, meaning, at no additional cost to you, I will earn a commission if you click through and make a purchase.</p>
</aside>
EOT;
}

/**
 * Inject an affiliate disclosure at the beginning of any post that contains affiliate links.
 *
 * @param string $content The post content.
 * @return string The filtered post content.
 */
function prepend_affiliate_disclosure( $content ) {
	$domains = [
		'amzn.to',
		'stevegrunwell.com/r',
	];

	// Escape the domains.
	array_walk( $domains, function ( &$domain ) {
		$domain = preg_quote( $domain, '/' );
	} );

	// Build the regex pattern.
	$pattern = '/(' . implode( '|', $domains ) . ')\/*/i';

	if ( preg_match( $pattern, $content ) ) {
		return get_disclosure() . $content;
	}

	return $content;
}
add_filter( 'the_content', __NAMESPACE__ . '\prepend_affiliate_disclosure' );
