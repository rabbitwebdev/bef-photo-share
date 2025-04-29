<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

// Register CPT
function post_type_photo_share() {
	$labels = array(
		'name'               => _x( 'Photo Shares', 'Photo Share General Name', 'bef-photo-share' ),
		'singular_name'      => _x( 'Photo Share', 'Photo Share Singular Name', 'bef-photo-share' ),
		'menu_name'          => __( 'Photo Shares', 'bef-photo-share' ),
		'name_admin_bar'     => __( 'Photo Share', 'bef-photo-share' ),
		'archives'           => __( 'Item Archives', 'bef-photo-share' ),
		'attributes'         => __( 'Item Attributes', 'bef-photo-share' ),
		'parent_item_colon'  => __( 'Parent Item:', 'bef-photo-share' ),
		'all_items'          => __( 'All Items', 'bef-photo-share' ),
		'add_new_item'       => __( 'Add New Item', 'bef-photo-share' ),
		'add_new'            => __( 'Add New', 'bef-photo-share' ),
		'new_item'           => __( 'New Item', 'bef-photo-share' ),
		'edit_item'          => __( 'Edit Item', 'bef-photo-share' ),
		'update_item'        => __( 'Update Item', 'bef-photo-share' ),
		'view_item'          => __( 'View Item', 'bef-photo-share' ),
		'view_items'         => __( 'View Items', 'bef-photo-share' ),
		'search_items'       => __( 'Search Item', 'bef-photo-share' ),
		'not_found'          => __( 'Not found', 'bef-photo-share' ),
		'not_found_in_trash' => __( 'Not found in Trash', 'bef-photo-share' ),
	);

	$args = array(
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail', 'editor', 'custom-fields' ),
		'public'                => true,
		'show_in_rest'          => true, // controls gutenberg
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
        'query_var'            => true,
        'show_ui'              => true,
		'menu_icon'             => 'dashicons-format-image',
	);
	register_post_type( 'photo-share', $args );
}
add_action( 'init', 'post_type_photo_share', 0 );