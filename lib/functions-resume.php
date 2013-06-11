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
        'projInfo-meta',
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

    // array(
    //     'label'=> 'Text Input',
    //     'desc'  => 'A description for the field.',
    //     'id'    => $prefix.'text',
    //     'type'  => 'text'
    // ),

    // array(
    //     'label'=> 'Textarea',
    //     'desc'  => 'A description for the field.',
    //     'id'    => $prefix.'textarea',
    //     'type'  => 'textarea'
    // ),

    // array(
    //     'label'=> 'Checkbox Input',
    //     'desc'  => 'A description for the field.',
    //     'id'    => $prefix.'checkbox',
    //     'type'  => 'checkbox'
    // ),

    // array(
    //     'label'=> 'Select Box',
    //     'desc'  => 'A description for the field.',
    //     'id'    => $prefix.'select',
    //     'type'  => 'select',
    //     'options' => array (
    //         'one' => array (
    //             'label' => 'Option One',
    //             'value' => 'one'
    //         ),
    //         'two' => array (
    //             'label' => 'Option Two',
    //             'value' => 'two'
    //         ),
    //         'three' => array (
    //             'label' => 'Option Three',
    //             'value' => 'three'
    //         )
    //     )
    // ),

    array(
        'label'=> 'Experience',
        'desc'  => 'Work Experience Meta',
        'id'    => $prefix.'experience',
        'type'  => 'experience'
       ),

    // array(
    //     'label'  => 'Images',
    //     'desc'  => 'Images for Resume projects.',
    //     'id'    => $prefix.'image',
    //     'type'  => 'image'
    // ),

    // array(
    //     'label'=> 'Live Site URL',
    //     'desc'  => 'URL to direct "Visit Live Site" link to.',
    //     'id'    => $prefix.'url',
    //     'type'  => 'url'
    // )
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
        $meta = get_post_meta($post->ID, $field['id'], true);
        // begin a table row with
        echo '<tr>
                <th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
                <td>';
                switch($field['type']) {

                    // text
                    case 'text':
                        echo '<input type="text" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;

                    // url
                    case 'url':
                        echo '<input type="url" name="'.$field['id'].'" id="'.$field['id'].'" value="'.$meta.'" size="30" />
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;

                    // textarea
                    case 'textarea':
                        echo '<textarea name="'.$field['id'].'" id="'.$field['id'].'" cols="60" rows="4">'.$meta.'</textarea>
                            <br /><span class="description">'.$field['desc'].'</span>';
                    break;

                    // checkbox
                    case 'checkbox':
                        echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                            <label for="'.$field['id'].'">'.$field['desc'].'</label>';
                    break;

                    // select
                    case 'select':
                        echo '<select name="'.$field['id'].'" id="'.$field['id'].'">';
                        foreach ($field['options'] as $option) {
                            echo '<option', $meta == $option['value'] ? ' selected="selected"' : '', ' value="'.$option['value'].'">'.$option['label'].'</option>';
                        }
                        echo '</select><br /><span class="description">'.$field['desc'].'</span>';
                    break;

                    // image
                    case 'image':

                        echo '<a class="repeatable-add button" href="#">+</a>
                                <ul id="'.$field['id'].'-repeatable" class="image_repeatable">';
                        $i = 0;
                        if ($meta) {
                            foreach($meta as $row) {
                                echo '<li><span class="sort hndle">|||</span>';
                                $image = get_template_directory_uri().'/images/logo.png';
                                echo '<span class="resume_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $row, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="resume_upload_image" value="'.$row.'" />
                                            <img src="'.$image.'" class="resume_preview_image" alt="" /><br />
                                                <input class="resume_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="resume_clear_image_button">Remove Image</a></small>
                                                <a class="repeatable-remove button" href="#">-</a></li>';;
                                $i++;
                            }
                        } else {
                            echo '<li><span class="sort hndle">|||</span>';
                                $image = get_template_directory_uri().'/images/logo.png';
                                echo '<span class="resume_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $meta, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="resume_upload_image initial-image" value="" />
                                            <img src="'.$image.'" class="resume_preview_image" alt="" /><br />
                                                <input class="resume_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="resume_clear_image_button">Remove Image</a></small>
                                        <a class="repeatable-remove button" href="#">-</a></li>';
                        }
                        echo '</ul>
                            <span class="description">'.$field['desc'].'</span>';
                    break;

                    case 'experience':

						echo '<a class="repeatable-add button" href="#">+</a>
								<ul id="'.$company['id'].'-repeatable" class="custom_repeatable">';
						$i = 0;
						if ($meta) {
							foreach($meta as $row) {
								echo '<li><span class="sort hndle">|||</span><br />';
								echo '<label>Company Name</label><br />';
								echo '<input type="text" name="'.$company.['id'].'['.$i.']" id="'.$company.['id'].'" value="'.$row.'" size="30" /><br />';
								echo '<label>Location</label><br />';
								echo '<input type="text" name="'.$location['id'].'['.$i.']" id="'.$location['id'].'" value="'.$row.'" size="30" /><br />';


								echo '<a class="repeatable-remove button" href="#">-</a></li>';
								$i++;
							}
						} else {
								echo '<li><span class="sort hndle">|||</span><br />';
								echo '<label>Company Name</label><br />';
								echo '<input type="text" name="'.$company['id'].'['.$i.']" id="'.$company.['id'].'" value="'.$row.'" size="30" /><br />';
								echo '<label>Location</label><br />';
								echo '<input type="text" name="'.$location['id'].'['.$i.']" id="'.$location['id'].'" value="'.$row.'" size="30" /><br />';
						}
						echo '</ul>
							<span class="description">'.$field['desc'].'</span>';
                    break;

                } //end switch
        echo '</td></tr>';
    } // end foreach
    echo '</table>'; // end table
}

// Save the Data
function save_resume_meta($post_id) {
    global $resume_meta_fields;

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
    foreach ( $resume_meta_fields as $field ) {
        $old = get_post_meta( $post_id, $field['id'], true );
        $new = $_POST[$field['id']];
        if ( $new && $new != $old ) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ( '' == $new && $old ) {
            delete_post_meta( $post_id, $field['id'], $old );
        }
    } // end foreach
}
add_action('save_post', 'save_resume_meta');

// Save the Data
function save_resume_experience_meta($post_id) {
    global $resume_meta_fields;

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
    foreach ( $resume_meta_fields as $field ) {
        $old_company = get_post_meta( $post_id, $company.['id'], true );
        $old_location = get_post_meta( $post_id, $location.['id'], true)
        $new_company = $_POST[$company.['id']];
        $new_location = $_POST[$location.['id']];

        if ( $new_company && $new_company != $old_company ) {
            update_post_meta($post_id, $company.['id'], $new_company);
            update_post_meta($post_id, $location.['id'], $new_location);

        } elseif ( '' == $new_company && $old_company ) {
            delete_post_meta( $post_id, $company.['id'], $old_company );
            delete_post_meta( $post_id, $location.['id'], $old_location );

        }
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