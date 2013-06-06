<?php
	include( TEMPLATEPATH . '/lib/portfolio-meta.php' );
?>

<?php
	if (have_posts()) : while (have_posts()) : the_post();
	    $title= str_ireplace('"', '', trim(get_the_title()));
	    $desc= trim(strip_tags( get_post_meta($portfolio_images[0], '_wp_attachment_image_alt', true) ));
 ?>
	<article class="row portfolio-details hentry">
		<div class="large-6 columns">
			<?php
				$detect = new Mobile_Detect();
				$mobile = false;
				if ($detect->isTablet()) {
					$url = portfolio_screenshot_url($post->ID);
					$mobile = true;
				} elseif ($detect->isMobile()) {
					$url = portfolio_screenshot_url($post->ID, array(387, 290));
					$mobile = true;
				} else {
					$url = portfolio_screenshot_url($post->ID);
				}
			 ?>
			<span class=screenshot-wrap><img class="screen-shot" src="<?php print $url; ?>" title="<?=$desc?>" alt="<?=$desc?>"></span>
		</div>
		<div class="large-2 columns portfolio-thumbs">
			<ul>
				<?php
					$portfolio_images = array_slice($portfolio_images, 0);
					$count = 1;
					foreach ( $portfolio_images as $portfolio_image ) {
						// if( $portfolio_image === 0 ) continue;
						$screenShot = wp_get_attachment_url( $portfolio_image );
						echo '<li class="portfolio-thumbnail';
						if( $count == 1 ) {
							echo ' active"><a href="';
							echo $screenShot;
							echo '" data-image="';
						} else {
							echo '"><a href="';
							echo $screenShot;
							echo '" data-image="';
						}
						echo $screenShot;

						$image = wp_get_attachment_image_src($portfolio_image, 'thumbnail');
						echo '"><img alt="Screen-shot thumbnail image." src="' . $image[0] . '"></a></li>';

						$count++;
					}
				 ?>
			</ul>
		</div>
		<div class="large-4 columns project-info">
			<h1 class="project-roles"><?php
	            $terms = get_the_terms($post->ID, 'project-type');
	            foreach($terms as $term) {
	              echo '<span class="project-role ' . $term->slug . '">' . $term->name . '</span>';
	            }
            ?></h1>
			<?php the_title('<h2 class="project-title">', '</h2>'); ?>
			<hr>

			<?php if ($item_link != '') : ?>
				<p class="domain-name"><a href="<?php echo $item_link; ?>"><i class="icon-globe"></i> <?php extract_domain_name($item_link); ?></a></p>
			<?php endif; ?>
			<?php $content = get_the_content() ?>
			<?php if( $content != '') : ?>
				<div class="entry-content">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
            <?php $project_tags = get_the_tags();
        	if ($project_tags != '') { ?>
	        	<p class="project-tags"><i class="icon-tag"></i>
	        		<?php foreach($project_tags as $tag) {
	        			echo '<a  class="project-tag ' . $tag->slug . '" href="/project-attributes/' . $tag->slug . '/" rel="tag" title="View More ' . $tag->name . ' Projects">' . $tag->name . '</a>';
					 } ?>
				</p>
        	<?php } ?>
			<?php if ($item_link != '') : ?>
			 	<p class="site-btn"><a class="btn" href="<?php echo $item_link; ?>">Visit Site &raquo;</a></p>
			<?php endif; ?>
		</div>
	</article>
<?php endwhile; endif; ?>


<div class="large-12 columns single-pager" style="margin-top:30px">
	<nav class="post-nav row">
	    <ul class="pager">
	    	<?php if($mobile == false) : ?>
				<li class="prev"><?php previous_post_link( '%link', '&laquo; View <strong>%title</strong> Project Details' ); ?></li>
		    	<li class="next"><?php next_post_link( '%link', 'View <strong>%title</strong> Project Details &raquo;' ); ?></li>
		    <?php else : ?>
				<li class="prev"><?php previous_post_link( '%link', '&laquo; Previous Project' ); ?></li>
		    	<li class="next"><?php next_post_link( '%link', 'Next Project &raquo;' ); ?></li>
			<?php endif; ?>
		</ul>
	</nav>
</div>
<?php wp_reset_query() ?>