<?php

	// Cache Portfolio Meta for use in templates
	$post_meta_data = get_post_custom($post->ID);

	// Portfolio Images
	$portfolio_images = unserialize( $post_meta_data['portfolio_image'][0] );
	$item_link = $post_meta_data['portfolio_url'][0];

	function extract_domain_name($url) {
		// get host name from URL, i.e. www.yoursite.com
		preg_match('@^(?:http://)?([^/]+)@i',
		    $url, $matches);
		$host = $matches[1];

		// get last two segments of host name, i.e. yoursite.com
		preg_match('/[^.]+\.[^.]+$/', $host, $matches);
		echo $matches[0];
	}

	function rwd_abbr_function($term){
		$name = $term->name;
		echo '<span class="project-role ' . $term->slug . '">';
		if ($name == 'Responsive Web Design') {

			echo '<abbr title="' . $name . '">RWD</abbr>';
		} else {
			echo $name;
		}
		echo '</span>';
	}
