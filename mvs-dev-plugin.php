<?php
/**
 * Plugin Name:       Mvs Dev Plugin
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mvs-dev-plugin
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function equipment_library_render_callback($block_attributes, $content){
   return '<p>OMG SUCCESS!</p>';
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function multiblock_register_blocks() {
	register_block_type( __DIR__ . '/build/blocks/ce-event-list-block' );
	register_block_type( __DIR__ . '/build/blocks/equipment-library-block');
}
add_action( 'init', 'multiblock_register_blocks' );
