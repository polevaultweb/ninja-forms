<?php

/*
 *
 * Function that registers our custom post type for submissions.
 *
 * @since 2.3.0
 * @return void
 */

function ninja_forms_register_sub_cpt(){

	$labels = array(
	    'name' => _x('Submissions', 'post type general name', 'ninja-forms'),
	    'singular_name' => _x('Submission', 'post type singular name', 'ninja-forms'),
	    'add_new' => _x('Add New', 'review', 'ninja-forms'),
	    'add_new_item' => __('Add New Submission', 'ninja-forms'),
	    'edit_item' => __('Edit Submission', 'ninja-forms'),
	    'new_item' => __('New Submission', 'ninja-forms'),
	    'all_items' => __('All Submissions', 'ninja-forms'),
	    'view_item' => __('View Submission', 'ninja-forms'),
	    'search_items' => __('Search Reviews', 'ninja-forms'),
	    'not_found' =>  __('No submissions found', 'ninja-forms'),
	    'not_found_in_trash' => __('No submissions found in Trash', 'ninja-forms'),
	    'parent_item_colon' => '',
	    'menu_name' => __('Reviews', 'ninja-forms')
  );
	$args = array(
		'labels' => $labels,
		'public' => false,
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'show_in_menu' => false,
		'show_in_admin_bar' => true,
		'menu_position' => 5,
		'menu_icon' => '',
		'map_meta_cap' => true,
		'hierarchical' => true,
		'has_archive' => false,
		'rewrite' => false,
		'can export' => true,
		'supports' => array( 'author', 'custom-fields' ),
		'capability_type' => 'post',
		'capabilities' => array( 'edit_post', 'read_post', 'delete_post', 'edit_posts', 'edit_others_posts', 'publish_posts', 'read_private_posts', 'read', 'delete_posts', 'delete_private_posts', 'delete_published_posts', 'delete_others_posts', 'edit_private_posts', 'edit_published_posts' ),
		'taxonomies' => array(),
	);

  register_post_type('ninja_forms_sub', $args);

}

add_action( 'init', 'ninja_forms_register_sub_cpt' );