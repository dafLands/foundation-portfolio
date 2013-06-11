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
        // 'menu_icon' => 'http://www.jasonmgarner.com/wp-admin/images/menu.png?ver=20121105',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
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


// Custom Meta Boxes
// ---------------------------------------------------------

add_action( 'load-post.php', 'resume_meta_boxes_setup' );
add_action( 'load-post-new.php', 'resume_meta_boxes_setup' );

function resume_meta_boxes_setup() {

    // Add Custom Meta
    add_action( 'add_meta_boxes', 'resume' );

    // Save Custom Meta
    add_action('save_post', 'save_resume_meta', 10, 2);

}

function resume(){
    add_meta_box(
        'resume-meta',
        esc_html__('Resume Options', 'foundation_portfolio'),
        'show_resume',
        'Resume',
        'normal',
        'default'
    );
}

// Prefix for reusable fields
$prefix = 'resume_';

// Array of reusable fields
$resume_meta_fields = array(
    // Order here affects order displayed in admin

    array(
        'label'=> 'Experience',
        'desc'  => 'Work Experience Meta',
        'id'    => $prefix.'experience',
        'type'  => 'experience'
       ),

);


// The Callback
function show_resume() {
global $resume_meta_fields, $post;

    // Use nonce for verification
    // echo '<input type="hidden" name="resume_nonce" value="'.wp_create_nonce( basename( __FILE__ ) ).'" />';
    wp_nonce_field( basename( __FILE__ ), 'resume_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($resume_meta_fields as $field) {
        // get value of this field if it exists for this post
        $company = $field['id'].'_company';
        $meta_company = get_post_meta($post->ID, $company, true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {

                    case 'experience':
                    	$i = 0;
				        // $meta_company = get_post_meta( $post->ID, $field['id'], true )
						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$field['id'].'_repeatable" class="'.$field['id'].'_repeatable">';
						echo '<li style="border-bottom:1px solid #ccc; padding-bottom:20px; margin-bottom: 20px;"><span style="padding: 5px; border-top:1px solid #ccc; border-left:1px solid #ccc; border-right:1px solid #ccc; border-radius: 3px" class="sort hndle">|||</span><br />';

						if ($meta_company) {
							foreach($meta_company as $row) {
								echo '<label>Company Name</label><br />';
								echo '<input type="text" name="'.$company.'['.$i.']" id="'.$company.$i.'" value="'.$row.'" size="30" /><br />';
								echo '<label>Location</label><br />';
								echo '<input type="text" name="'.$field['id'].'_location['.$i.']" id="'.$field['id'].'_location_'.$i.'" value="'.$row.'" size="30" /><br />';
								echo '<label>Responsibilities and Accomplishments</label><br />';
								echo '<textarea name="'.$field['id'].'_duties['.$i.']" id="'.$field['id'].'_duties_'.$i.'" cols="60" rows="4">'.$row.'</textarea><br />';
								echo '<label>Start Date</label><br />';
								echo '<input type="text" name="'.$field['id'].'_start['.$i.']" id="'.$field['id'].'_start_'.$i.'" value="'.$row.'" size="30" /><br />';
								echo '<label>End Date</label><br />';
								echo '<input type="text" name="'.$field['id'].'_end['.$i.']" id="'.$field['id'].'_end_'.$i.'" value="'.$row.'" size="30" /><br />';


								echo '<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
								echo '<label>Company Name</label><br />';
								echo '<input type="text" name="'.$company.'['.$i.']" id="'.$company.$i.'" value="" size="30" /><br />';
								echo '<label>Location</label><br />';
								echo '<input type="text" name="'.$field['id'].'_location['.$i.']" id="'.$field['id'].'_location_'.$i.'" value="" size="30" /><br />';
								echo '<label>Responsibilities and Accomplishments</label><br />';
								echo '<textarea name="'.$field['id'].'_duties['.$i.']" id="'.$field['id'].'_duties_'.$i.'" cols="60" rows="4"></textarea><br />';
								echo '<label>Start Date</label><br />';
								echo '<input type="text" name="'.$field['id'].'_start['.$i.']" id="'.$field['id'].'_start_'.$i.'" value="" size="30" /><br />';
								echo '<label>End Date</label><br />';
								echo '<input type="text" name="'.$field['id'].'_end['.$i.']" id="'.$field['id'].'_end_'.$i.'" value="" size="30" /><br />';

						}
						echo '</li></ul>
							<span class="description">'.$field['desc'].'</span>';
                    break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_resume_experience_meta($post_id) {
    global $resume_meta_fields;
    $i = 0;

    // verify nonce
    if ( !wp_verify_nonce( $_POST['resume_nonce'], basename( __FILE__ ) ) )
        return $post_id;
    // check autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;
    // check permissions
    if ( 'page' == $_POST['post_type'] ) {
        if ( !current_user_can( 'edit_page', $post_id ) )
            return $post_id;
        } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
    }

    // loop through fields and save the data
    foreach ( $resume_meta_fields as $company ) {
        // $old = get_post_meta( $post_id, $field['id'], true );
        // $new = $_POST[$field['id']];
        $old_company = get_post_meta( $post_id, $company, true );
        $new_company = $_POST[$company];

        if ( $new_company && $new_company != $old_company ) {
            update_post_meta($post_id, $company, $new_company);

        } elseif ( '' == $new_company && $old_company ) {
            delete_post_meta( $post_id, $company, $old_company);

        }
        $i++;
    } // end foreach

}
add_action('save_post', 'save_resume_experience_meta');

// Custom Admin Script
add_action( 'admin_print_scripts-post-new.php', 'resume_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'resume_admin_script', 11 );

function resume_admin_script() {
    global $post_type;
    if( 'resume' == $post_type )
	    wp_enqueue_script( 'resume-admin-script', get_stylesheet_directory_uri() . '/javascripts/jquery.resume.js' );
}