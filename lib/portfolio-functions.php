<?php
// Custom Thumbnails to be used in our Portfolio
// ---------------------------------------------------------

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 387, 290 ); // Normal post thumbnails
	add_image_size( 'portfolio-preview', 80, 60, true );
	add_image_size( 'screen-shot', 800, 9999 ); // Large Portfolio Image
}

// Removes height and width attributes from "the_post_thumbnail"
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

// Custom Admin Script
add_action( 'admin_print_scripts-post-new.php', 'portfolio_admin_script', 11 );
add_action( 'admin_print_scripts-post.php', 'portfolio_admin_script', 11 );

function portfolio_admin_script() {
    global $post_type;
    if( 'portfolio' == $post_type )
    wp_enqueue_script( 'portfolio-admin-script', get_stylesheet_directory_uri() . '/javascripts/jquery.portfolio.js' );
}

// Add support for cropping default WordPress medium images -
if(!get_option("medium_crop")) {
    add_option("medium_crop", "1");
}
else {
    update_option("medium_crop", "1");
}

// Custom Post-Type
// ---------------------------------------------------------
add_action( 'init', 'register_portfolio_post_type' );

function register_portfolio_post_type() {

    $labels = array(
        'name' => _x( 'Portfolio', 'portfolio' ),
        'singular_name' => _x( 'Portfolio Item', 'portfolio_item' ),
        'add_new' => _x( 'Add New', 'portfolio_item' ),
        'add_new_item' => _x( 'Add New Portfolio Item', 'portfolio_item' ),
        'edit_item' => _x( 'Edit Portfolio Item', 'portfolio_item' ),
        'new_item' => _x( 'New Portfolio Item', 'portfolio_item' ),
        'view_item' => _x( 'View Portfolio Item', 'portfolio_item' ),
        'search_items' => _x( 'Search Portfolio', 'portfolio_item' ),
        'not_found' => _x( 'No portfolio found', 'portfolio_item' ),
        'not_found_in_trash' => _x( 'No portfolio found in Trash', 'portfolio_item' ),
        'parent_item_colon' => _x( 'Parent Portfolio Item:', 'portfolio_item' ),
        'menu_name' => _x( 'Portfolio', 'portfolio_item' ),
    );

    $taxonomies = array(
        'post_tag'
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Post type for displaying online Portfolio',
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
        'rewrite' => array( 'slug' => 'work'),
        'capability_type' => 'post',
        'taxonomies' => $taxonomies
    );

    register_post_type( 'portfolio', $args );
}

// Custom Taxonomies
// ---------------------------------------------------------
add_action( 'init', 'register_portfolio_taxonomies', 0 );

function register_portfolio_taxonomies() {

	$labels = array(
	    'name'                => _x( 'Project Types', 'taxonomy general name' ),
	    'singular_name'       => _x( 'Project Type', 'taxonomy singular name' ),
	    'search_items'        => _( 'Search Project Types' ),
	    'all_items'           => _( 'All Project Types' ),
	    'parent_item'         => _( 'Parent Project Type' ),
	    'parent_item_colon'   => _( 'Parent Project Type:' ),
	    'edit_item'           => _( 'Edit Project Type' ),
	    'update_item'         => _( 'Update Project Type' ),
	    'add_new_item'        => _( 'Add New Project Type' ),
	    'new_item_name'       => _( 'New Project Type Name' ),
	    'menu_name'           => _( 'Project Type' )
	);

	$args = array(
	    'hierarchical'        => true,
	    'labels'              => $labels,
	    'show_ui'             => true,
	    'show_admin_column'   => true,
	    'query_var'           => true,
	    'rewrite'             => true
	);

	register_taxonomy( 'project-type', array('portfolio'), $args );
}

add_action('init', 'custom_taxonomy_flush_rewrite');
function custom_taxonomy_flush_rewrite() {
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
    if($post_type)
        $post_type = $post_type;
    else
        $post_type = array('post','portfolio'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
    return $query;
    }
}


// Custom Meta Boxes
// ---------------------------------------------------------

add_action( 'load-post.php', 'portfolio_meta_boxes_setup' );
add_action( 'load-post-new.php', 'portfolio_meta_boxes_setup' );

function portfolio_meta_boxes_setup() {

    // Add Custom Meta
    add_action( 'add_meta_boxes', 'portfolio_meta_box' );

    // Save Custom Meta
    add_action('save_post', 'save_portfolio_meta', 10, 2);

}

function portfolio_meta_box(){
    add_meta_box(
        'projInfo-meta',
        esc_html__('Portfolio Options', 'foundation-portfolio'),
        'show_portfolio_meta_box',
        'portfolio',
        'normal',
        'default'
    );
}

// Prefix for reusable fields
$prefix = 'portfolio_';

// Array of reusable fields
$portfolio_meta_fields = array(
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
        'label'  => 'Images',
        'desc'  => 'Images for portfolio projects.',
        'id'    => $prefix.'image',
        'type'  => 'image'
    ),
    array(
        'label'=> 'Live Site URL',
        'desc'  => 'URL to direct "Visit Live Site" link to.',
        'id'    => $prefix.'url',
        'type'  => 'url'
    )
);

// The Callback
function show_portfolio_meta_box() {
global $portfolio_meta_fields, $post;

    // Use nonce for verification
    // echo '<input type="hidden" name="portfolio_meta_box_nonce" value="'.wp_create_nonce( basename( __FILE__ ) ).'" />';
    wp_nonce_field( basename( __FILE__ ), 'portfolio_meta_box_nonce' );

    // Begin the field table and loop
    echo '<table class="form-table">';
    foreach ($portfolio_meta_fields as $field) {
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
                                echo '<span class="portfolio_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $row, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="portfolio_upload_image" value="'.$row.'" />
                                            <img src="'.$image.'" class="portfolio_preview_image" alt="" /><br />
                                                <input class="portfolio_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="portfolio_clear_image_button">Remove Image</a></small>
                                                <a class="repeatable-remove button" href="#">-</a></li>';;
                                $i++;
                            }
                        } else {
                            echo '<li><span class="sort hndle">|||</span>';
                                $image = get_template_directory_uri().'/images/logo.png';
                                echo '<span class="portfolio_default_image" style="display:none">'.$image.'</span>';
                                $image = wp_get_attachment_image_src( $meta, 'thumbnail' ); $image = $image[0];
                                echo    '<input name="'.$field['id'].'['.$i.']" type="hidden" class="portfolio_upload_image initial-image" value="" />
                                            <img src="'.$image.'" class="portfolio_preview_image" alt="" /><br />
                                                <input class="portfolio_upload_image_button button" type="button" value="Choose Image" />
                                                <small> <a href="#" class="portfolio_clear_image_button">Remove Image</a></small>
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
function save_portfolio_meta($post_id) {
    global $portfolio_meta_fields;

    // verify nonce
    if ( !wp_verify_nonce( $_POST['portfolio_meta_box_nonce'], basename( __FILE__ ) ) )
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
    foreach ( $portfolio_meta_fields as $field ) {
        $old = get_post_meta( $post_id, $field['id'], true );
        $new = $_POST[$field['id']];
        if ( $new && $new != $old ) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ( '' == $new && $old ) {
            delete_post_meta( $post_id, $field['id'], $old );
        }
    } // end foreach
}
add_action('save_post', 'save_portfolio_meta');

// Custom Admin View Columns
// ---------------------------------------------------------

// GET FEATURED IMAGE
function get_portfolio_preview($post_ID) {
	$post_thumbnail_id = get_post_thumbnail_id($post_ID);
	if ($post_thumbnail_id) {
		$post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'portfolio-preview');
		return $post_thumbnail_img[0];
	}
}

add_filter("manage_edit-portfolio_columns", "project_edit_columns");

function project_edit_columns($columns){
        $columns = array(
            "cb" => "<input type=\"checkbox\" />",
            "title" => "Project",
            "feat-preview" => 'Preview',
            "description" => "Description",
            "link" => "Live Site Link",
            "type" => "Type of Project",
        );

        return $columns;
}

add_action("manage_posts_custom_column",  "project_custom_columns");

function project_custom_columns($column){
        $post_id = get_the_ID();
        $post_meta_data = get_post_custom($post_id);

        switch ($column)
        {
            case "description":
                the_excerpt();
                break;
            case "link":
                $item_link = get_post_meta( $post_id, 'portfolio_url', true );
                echo $item_link;
                break;
            case "type":
                echo get_the_term_list($post_id , 'project-type', '', ', ','');
                break;
            case "feat-preview":
                if ( isset( $post_meta_data['portfolio_image'][0] ) ) {
                    $portfolio_images = unserialize( $post_meta_data['portfolio_image'][0] );
                    echo wp_get_attachment_image($portfolio_images[0], 'portfolio-preview');
                } else {
                	$portfolio_preview_image = get_portfolio_preview($post_id);
                	echo '<img src="' . $portfolio_preview_image . '" />';
                }
            	break;
        }
}

// Custom Display Functions
// ---------------------------------------------------------

function portfolio_screenshot_url($pid){
    $post_meta_data = get_post_custom($pid);
    $portfolio_images = unserialize( $post_meta_data['portfolio_image'][0] );
	$image_id = get_post_thumbnail_id($pid);
	$image_url = wp_get_attachment_image_src($portfolio_images[0],'screen-shot');
	return  $image_url[0];
}

function portfolio_image_url($pid, $imageSize = '', $imageNum = 0){
    $post_meta_data = get_post_custom($pid);
    $portfolio_images = unserialize( $post_meta_data['portfolio_image'][$imageNum] );
    $image_id = get_post_thumbnail_id($pid);
    $image_url = wp_get_attachment_image_src($portfolio_images[$imageNum], $imageSize);
    return  $image_url[$imageNum];
}

function portfolio_posts_per_page( $query ) {
    if ( $query->query_vars['post_type'] == 'portfolio' ) $query->query_vars['posts_per_page'] = 1;
    return $query;
}
if ( !is_admin() ) add_filter( 'pre_get_posts', 'portfolio_posts_per_page' );