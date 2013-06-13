<?php

// Custom Post-Type
// ---------------------------------------------------------
add_action( 'init', 'register_resume_post_type' );

function register_resume_post_type() {

    $labels = array(
        'name' => _x( 'Resume', 'resume' ),
        'singular_name' => _x( 'Resume Item', 'resume_item' ),
        'add_new' => _x( 'Add New', 'resume_item' ),
        'add_new_item' => _x( 'Add New Resume Item', 'resume_item' ),
        'edit_item' => _x( 'Edit Resume Item', 'resume_item' ),
        'new_item' => _x( 'New Resume Item', 'resume_item' ),
        'view_item' => _x( 'View Resume Item', 'resume_item' ),
        'search_items' => _x( 'Search Resume', 'resume_item' ),
        'not_found' => _x( 'No Resume found', 'resume_item' ),
        'not_found_in_trash' => _x( 'No Resume found in Trash', 'resume_item' ),
        'parent_item_colon' => _x( 'Parent Resume Item:', 'resume_item' ),
        'menu_name' => _x( 'Resume', 'resume_item' ),
    );

    $taxonomies = array(
        'post_tag'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Post type for displaying Resume',
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        // 'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'resume'),
        'capability_type' => 'post',
        'taxonomies' => $taxonomies
    );

    register_post_type( 'resume', $args );
}

// Custom Taxonomies
// ---------------------------------------------------------
add_action( 'init', 'register_resume_taxonomies', 0 );

function register_resume_taxonomies() {

	$labels = array(
	    'name'                => _x( 'Resume Item', 'taxonomy general name' ),
	    'singular_name'       => _x( 'Resume Item', 'taxonomy singular name' ),
	    'search_items'        => _( 'Search Resume Item' ),
	    'all_items'           => _( 'All Resume Item' ),
	    'parent_item'         => _( 'Parent Resume Item' ),
	    'parent_item_colon'   => _( 'Parent Resume Item:' ),
	    'edit_item'           => _( 'Edit Resume Item' ),
	    'update_item'         => _( 'Update Resume Item' ),
	    'add_new_item'        => _( 'Add New Resume Item' ),
	    'new_item_name'       => _( 'New Resume Item Name' ),
	    'menu_name'           => _( 'Resume Item' )
	);

	$args = array(
	    'hierarchical'        => true,
	    'labels'              => $labels,
	    'show_ui'             => true,
	    'show_admin_column'   => true,
	    'query_var'           => true,
	    'rewrite'             => true
	);

	register_taxonomy( 'Resume Item', array('resume'), $args );
}

add_action('init', 'resume_taxonomy_flush_rewrite');
function resume_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

add_filter('pre_get_posts', 'resume_query_post_type');
function resume_query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('post','resume'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
    return $query;
    }
}