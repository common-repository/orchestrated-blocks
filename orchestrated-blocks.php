<?php
/**
 * Plugin Name: Orchestrated Blocks
 * Description: A set of blocks for WordPress and the Gutenberg editor.
 * Author: Orchestrated
 * Version: 1.0.9
 */

function orchestrated_blocks_load_block() {
  wp_enqueue_script( 'orchestrated-blocks-feature', plugin_dir_url(__FILE__) . '/dist/bundle.js', array('wp-blocks','wp-editor'), true );
}

function orchestrated_blocks_load_styles() {
  wp_register_style( 'orchestrated-blocks-tailwind', plugin_dir_url(__FILE__) . '/dist/css/tailwind.css' );
  wp_enqueue_style( 'orchestrated-blocks-tailwind' );
}

function orchestrated_blocks_load_admin_styles() {
  wp_register_style( 'orchestrated-blocks-dashboard', plugin_dir_url(__FILE__) . '/dist/css/dashboard.css' );
  wp_enqueue_style( 'orchestrated-blocks-dashboard' );
}

function orchestrated_blocks_theme_setup() {
  add_theme_support( 'disable-custom-colors' );
  add_theme_support( 'disable-custom-font-sizes' );
}

function orchestrated_blocks_get_theme_colors( WP_REST_Request $request ) {
  return get_theme_support( 'editor-color-palette' )[0];
}

function orchestrated_blocks_api_endpoints() {
  register_rest_route( 'orchestrated-blocks/v1', '/theme/colors', array(
    'methods' => 'GET',
    'callback' => 'orchestrated_blocks_get_theme_colors',
    'permission_callback' => function () {
      return true;
    }
  ) );
}

add_action( 'enqueue_block_editor_assets', 'orchestrated_blocks_load_block' );
add_action( 'admin_enqueue_scripts', 'orchestrated_blocks_load_admin_styles' );
add_action( 'after_theme_setup', 'orchestrated_blocks_theme_setup' );
add_action( 'wp_enqueue_scripts', 'orchestrated_blocks_load_styles' );
add_action( 'rest_api_init', 'orchestrated_blocks_api_endpoints' );
