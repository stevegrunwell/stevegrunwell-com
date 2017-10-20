<?php
/**
 * Utility functions.
 *
 * @package SteveGrunwellCom
 */

namespace SteveGrunwellCom\Utils;

/**
 * Merge one array into another immediately following a specified key.
 *
 * @param array  $parent The parent array, which we're inserting values into.
 * @param array  $insert The array to be inserted into $parent.
 * @param string $key    The key after which $insert should be inserted into $parent.
 * @return array The modified $parent array. If $key was not found, $insert will simply be merged
 *               using array_merge().
 *
 * @todo Good opportunity to get functional, but for where it's being used that'd absolutely be
 *       premature optimization.
 */
function array_merge_after_key( $parent, $insert, $key ) {
	if ( ! array_key_exists( $key, $parent ) ) {
		return array_merge( $parent, $insert );
	}

	$reordered = array();

	foreach ( $parent as $col => $value ) {
		$reordered[ $col ] = $value;

		if ( $col === $key ) {
			$reordered = array_merge( $reordered, $insert );
		}
	}

	return $reordered;
}
