<?php
/**
 * Plugin Name: Real Blocks Listings
 * Description: A Gutenberg block and custom post type to edit real estate listings
 * Version 0.0.1
 * Author: Michael Dietz

 * @package real-blocks
 */

defined( 'ABSPATH' ) || exit;

add_action('init', 'real_blocks_listing_register_block');
register_activation_hook( __FILE__, 'real_blocks_listing_install');

function real_blocks_listing_register_post_type() {
  $labels = [
    "name" => "Listings",
    "singular_name" => "Listing",
    "menu_name" => "Listings",
    "all_items" => "All Listings",
    "add_new_item" => "Add New Listing",
    "edit_item" => "Edit Listing",
    "new_item" => "New Listing",
		"view_item" => "View Listing",
		"view_items" => "View Listings",
		"search_items" => "Search Listings",
		"not_found" => "No listings found",
		"not_found_in_trash" => "No listings found in trash",
  ];
  $args = [
    "label" => "Listings",
    "labels" => $labels,
    "description" => "Layout block for a real estate listing",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "delete_with_user" => false,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => [ "slug" => "listing", "with_front" => true ],
    "query_var" => true,
    "menu_position" => 5,
    "menu_icon" => "dashicons-admin-home",
    "supports" => [ "title", "editor" ],
  ];

  register_post_type( "listing", $args );
}

function real_blocks_listing_register_post_meta() {
  register_post_meta( '', 'myguten_meta_block_field', array(
    'show_in_rest' => true,
    'single' => true,
    'type' => 'string'
  ));
  // register_post_meta( 'listing', 'rb_hero-img-src', array(
  //   'show_in_rest' => true,
  //   'single' => true,
  //   'type' => 'string'
  // ));
  // $val = register_post_meta( 'listing', 'rb_title', array(
  //   'show_in_rest' => true,
  //   'single' => true,
  //   'type' => 'string'
  // ));
  // register_post_meta( 'listing', 'rb_subtitle', array(
  //   'show_in_rest' => true,
  //   'single' => true,
  //   'type' => 'string'
  // ));
  // register_post_meta( 'listing', 'rb_teaser', array(
  //   'show_in_rest' => true,
  //   'single' => true,
  //   'type' => 'string'
  // ));
  // register_post_meta( 'listing', 'rb_content', array(
  //   'show_in_rest' => true,
  //   'single' => true,
  //   'type' => 'string'
  // ));
  // error_log($val);
}

function real_blocks_listing_register_block() {
  if ( ! function_exists( 'register_block_type' ) ) {
		// Gutenberg is not active.
		return;
	}

  real_blocks_listing_register_post_type();
  real_blocks_listing_register_post_meta();

  $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/index.asset.php');

  wp_register_script(
		'real-blocks-listing',
		plugins_url( 'build/index.js', __FILE__ ),
		$asset_file['dependencies'],
		$asset_file['version']
	);

  register_block_type('real-blocks/listing', array(
    'editor_script' => 'real-blocks-listing'
  ));
}

function real_blocks_listing_install() {
  real_blocks_listing_register_post_type();
  real_blocks_listing_register_post_meta();
  flush_rewrite_rules();
}
?>
