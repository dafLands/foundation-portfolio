<?php

// Custom Post-Type
// ---------------------------------------------------------
add_action( 'init', 'register_CUSTOM_post_type' );

function register_CUSTOM_post_type() {

    $labels = array(
        'name' => _x( 'CUSTOM_POST_TYPE', 'custom_post_type_slug' ),
        'singular_name' => _x( 'CUSTOM_POST_TYPE Item', 'CUSTOM_POST_TYPE_item' ),
        'add_new' => _x( 'Add New', 'CUSTOM_POST_TYPE_item' ),
        'add_new_item' => _x( 'Add New CUSTOM_POST_TYPE Item', 'CUSTOM_POST_TYPE_item' ),
        'edit_item' => _x( 'Edit CUSTOM_POST_TYPE Item', 'CUSTOM_POST_TYPE_item' ),
        'new_item' => _x( 'New CUSTOM_POST_TYPE Item', 'CUSTOM_POST_TYPE_item' ),
        'view_item' => _x( 'View CUSTOM_POST_TYPE Item', 'CUSTOM_POST_TYPE_item' ),
        'search_items' => _x( 'Search CUSTOM_POST_TYPE', 'CUSTOM_POST_TYPE_item' ),
        'not_found' => _x( 'No CUSTOM_POST_TYPE found', 'CUSTOM_POST_TYPE_item' ),
        'not_found_in_trash' => _x( 'No CUSTOM_POST_TYPE found in Trash', 'CUSTOM_POST_TYPE_item' ),
        'parent_item_colon' => _x( 'Parent CUSTOM_POST_TYPE Item:', 'CUSTOM_POST_TYPE_item' ),
        'menu_name' => _x( 'CUSTOM_POST_TYPE', 'CUSTOM_POST_TYPE_item' ),
    );

    $taxonomies = array(
        'post_tag'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Post type for displaying CUSTOM_POST_TYPE',
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
        'rewrite' => array( 'slug' => 'CUSTOM-POST-TYPE-ARCHIVE-SLUG'),
        'capability_type' => 'post',
        'taxonomies' => $taxonomies
    );

    register_post_type( 'custom_post_type_slug', $args );
}

// Custom Taxonomies
// ---------------------------------------------------------
add_action( 'init', 'register_CUSTOM_POST_TYPE_taxonomies', 0 );

function register_CUSTOM_POST_TYPE_taxonomies() {

	$labels = array(
	    'name'                => _x( 'CUSTOM_TAXONOMY', 'taxonomy general name' ),
	    'singular_name'       => _x( 'CUSTOM_TAXONOMY', 'taxonomy singular name' ),
	    'search_items'        => _( 'Search CUSTOM_TAXONOMY' ),
	    'all_items'           => _( 'All CUSTOM_TAXONOMY' ),
	    'parent_item'         => _( 'Parent CUSTOM_TAXONOMY' ),
	    'parent_item_colon'   => _( 'Parent CUSTOM_TAXONOMY:' ),
	    'edit_item'           => _( 'Edit CUSTOM_TAXONOMY' ),
	    'update_item'         => _( 'Update CUSTOM_TAXONOMY' ),
	    'add_new_item'        => _( 'Add New CUSTOM_TAXONOMY' ),
	    'new_item_name'       => _( 'New CUSTOM_TAXONOMY Name' ),
	    'menu_name'           => _( 'CUSTOM_TAXONOMY' )
	);

	$args = array(
	    'hierarchical'        => true,
	    'labels'              => $labels,
	    'show_ui'             => true,
	    'show_admin_column'   => true,
	    'query_var'           => true,
	    'rewrite'             => true
	);

	register_taxonomy( 'CUSTOM_TAXONOMY', array('custom_post_type_slug'), $args );
}

add_action('init', 'CUSTOM_POST_TYPE_taxonomy_flush_rewrite');
function CUSTOM_POST_TYPE_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

add_filter('pre_get_posts', 'CUSTOM_POST_TYPE_query_post_type');
function CUSTOM_POST_TYPE_query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('post','custom_post_type_slug'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
    return $query;
    }
}


// Custom Meta Boxes
// ---------------------------------------------------------

add_action( 'load-post.php', 'CUSTOM_POST_TYPE_meta_boxes_setup' );
add_action( 'load-post-new.php', 'CUSTOM_POST_TYPE_meta_boxes_setup' );

function CUSTOM_POST_TYPE_meta_boxes_setup() {

    // Add Custom Meta
    add_action( 'add_meta_boxes', 'CUSTOM_POST_TYPE' );

    // Save Custom Meta
    add_action('save_post', 'save_CUSTOM_POST_TYPE_meta', 10, 2);

}

function CUSTOM_POST_TYPE(){
    add_meta_box(
        'projInfo-meta',
        esc_html__('CUSTOM_POST_TYPE Options', 'THEME-NAME'),
        'show_CUSTOM_POST_TYPE',
        'CUSTOM_POST_TYPE',
        'normal',
        'default'
    );
}

// Prefix for reusable fields
$prefix = 'CUSTOM_POST_TYPE_';

// Array of reusable fields
$CUSTOM_POST_TYPE_meta_fields = array(
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
    // array(
    //     'label'  => 'Images',
    //     'desc'  => 'Images for CUSTOM_POST_TYPE projects.',
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
function show_CUSTOM_POST_TYPE() {
global $CUSTOM_POST_TYPE_meta_fields, $post;

    // Use nonce for verification
    // echo '<input type="hidden" name="CUSTOM_POST_TYPE_nonce" value="'.wp_create_nonce( basename( __FILE__ ) ).'" />';
    wp_nonce_field( basename( __FILE__ ), 'CUSTOM_POST_TYPE_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($CUSTOM_POST_TYPE_meta_fields as $field) {
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
                                echo '<span class="CUSTOM_POST_TYPE_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $row, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="CUSTOM_POST_TYPE_upload_image" value="'.$row.'" />
                                            <img src="'.$image.'" class="CUSTOM_POST_TYPE_preview_image" alt="" /><br />
                                                <input class="CUSTOM_POST_TYPE_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="CUSTOM_POST_TYPE_clear_image_button">Remove Image</a></small>
                                                <a class="repeatable-remove button" href="#">-</a></li>';;
                                $i++;
                            }
                        } else {
                            echo '<li><span class="sort hndle">|||</span>';
                                $image = get_template_directory_uri().'/images/logo.png';
                                echo '<span class="CUSTOM_POST_TYPE_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $meta, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="CUSTOM_POST_TYPE_upload_image initial-image" value="" />
                                            <img src="'.$image.'" class="CUSTOM_POST_TYPE_preview_image" alt="" /><br />
                                                <input class="CUSTOM_POST_TYPE_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="CUSTOM_POST_TYPE_clear_image_button">Remove Image</a></small>
                                        <a class="repeatable-remove button" href="#">-</a></li>';
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
function save_CUSTOM_POST_TYPE_meta($post_id) {
    global $CUSTOM_POST_TYPE_meta_fields;

    // verify nonce
    if ( !wp_verify_nonce( $_POST['CUSTOM_POST_TYPE_nonce'], basename( __FILE__ ) ) )
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
    foreach ( $CUSTOM_POST_TYPE_meta_fields as $field ) {
        $old = get_post_meta( $post_id, $field['id'], true );
        $new = $_POST[$field['id']];
        if ( $new && $new != $old ) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ( '' == $new && $old ) {
            delete_post_meta( $post_id, $field['id'], $old );
        }
    } // end foreach
}
add_action('save_post', 'save_CUSTOM_POST_TYPE_meta');