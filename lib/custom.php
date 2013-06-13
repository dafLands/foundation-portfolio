<?php
//--- Cleans up unnecessary code from head ---
// Remove links to the extra feeds (e.g. category feeds)
remove_action( 'wp_head', 'feed_links_extra', 3 );
// Remove links to the general feeds (e.g. posts and comments)
remove_action( 'wp_head', 'feed_links', 2 );
// Remove link to the RSD service endpoint, EditURI link
remove_action( 'wp_head', 'rsd_link' );
// Remove link to the Windows Live Writer manifest file
remove_action( 'wp_head', 'wlwmanifest_link' );
// Remove index link
remove_action( 'wp_head', 'index_rel_link' );
// Remove prev link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
// Remove start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
// Display relational links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
// Remove XHTML generator showing WP version
remove_action( 'wp_head', 'wp_generator' );

//--- Removes code inserted into content by use of <--more-->
// removes empty span
function remove_empty_read_more_span($content) {
	return eregi_replace("(<p><span id=\"more-[0-9]{1,}\"></span></p>)", "", $content);
}
add_filter('the_content', 'remove_empty_read_more_span');
// removes url hash to avoid the jump link
function remove_more_jump_link($link) {
   $offset = strpos($link, '#more-');
   if ($offset) {
      $end = strpos($link, '"',$offset);
   }
   if ($end) {
      $link = substr_replace($link, '', $offset, $end-$offset);
   }
   return $link;
}
add_filter('the_content_more_link', 'remove_more_jump_link');



//--- Improved Excerpt ---
function improved_trim_excerpt($text) {
   if ( '' == $text ) {
      $text = get_the_content('');
      $text = strip_shortcodes( $text );
      $text = apply_filters('the_content', $text);
      $text = str_replace(']]>', ']]&gt;', $text);
      $text = strip_tags($text, '<p><img><a>');
      $excerpt_length = apply_filters('excerpt_length', 55);
      $words = explode(' ', $text, $excerpt_length + 1);
      if (count($words) > $excerpt_length) {
         array_pop($words);
         array_push($words, '[...]');
         $text = implode(' ', $words);
         $text = force_balance_tags($text);
      }
   }
   return $text;
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'improved_trim_excerpt');


//--- Conditional Next/Prev Links
function show_posts_nav() {
   global $wp_query;
   return ($wp_query->max_num_pages > 1);
}

function paginate() {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    $pagination = array(
        'base' => @add_query_arg('page','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => true,
        'type' => 'plain'
    );
    if ( $wp_rewrite->using_permalinks() ) $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
    if ( !empty($wp_query->query_vars['s']) ) $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    echo paginate_links( $pagination );
 }

 // Turn absolute image urls into relative

function makeRelative($url) {
  echo parse_url($url, PHP_URL_PATH);
}

// Navigation menu fix for Category Pages
function getMainMenu($menulocation){
  $locations = get_nav_menu_locations();
  $menuItems = wp_get_nav_menu_items( $locations[ $menulocation ] );
    if(empty($menuItems))
      return false;
    else{
      wp_nav_menu( array(
        'theme_location' => $menulocation,
        'container' => 'false',
        'menu_class' => 'right'
        ) );
      return true;
    }
}