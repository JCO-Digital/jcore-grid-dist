<?php
/**
 * Handles registering the Gutenberg blocks.
 *
 * * @package jcore-grid
 */

namespace Jcore\Grid;

/**
 * Handles registering the blocks using the manifest collection file.
 *
 * @return void
 */
function register_blocks_metadata(): void {
	$base_path = join_path( JCORE_GRID_PLUGIN_PATH, 'blocks/build' );
	$manifest  = join_path( JCORE_GRID_PLUGIN_PATH, 'blocks/build/blocks-manifest.php' );

	if ( ! is_readable( $manifest ) ) {
		return;
	}

	wp_register_block_metadata_collection( $base_path, $manifest );
}

/**
 * Handles registering the blocks.
 *
 * This function will either use the register_block_type function (on WP < 6.7)
 * Or use the wp_register_block_metadata_collection when WP > 6.7 and the file exists.
 *
 * @return void
 */
function register_blocks(): void {
	if ( is_wp_version_compatible( '6.7' ) ) {
		register_blocks_metadata();
	}
	$blocks = array(
		'grid',
		'columns',
		'column',
	);
	foreach ( $blocks as $block ) {
		$block_file = join_path( JCORE_GRID_PLUGIN_PATH, 'blocks/build', $block, 'block.json' );
		if ( is_readable( $block_file ) ) {
			register_block_type( $block_file );
		}
	}
}
add_action( 'init', __NAMESPACE__ . '\register_blocks' );
