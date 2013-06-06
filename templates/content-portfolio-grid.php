<?php
 if (!have_posts()) : ?>
  <div class="alert">
    <?php _e('Sorry, no results were found.', 'foundation-portfolio'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
  <?php
        $title = str_ireplace('"', '', trim(get_the_title()));
        $desc = trim(strip_tags( get_post_meta($portfolio_images[0], '_wp_attachment_image_alt', true) ));
  ?>
  <article class="large-3 columns portfolio-item portfolio-grid" <?php // post_class(); ?>>
      <div class="portfolio-info img-wrap">
        <?php if ( has_post_thumbnail()): ?>
          <a class="image-link" href="<?php the_permalink(); ?>" title="View <?=$title?> Project Details"><?php the_post_thumbnail(); ?></a>
        <?php else: ?>
        <?php $url = portfolio_image_url($post->ID, array(387, 290));
         ?>
          <a class="image-link" href="<?php the_permalink(); ?>" title="View <?=$title?> Project Details"><img src="<?php print $url; ?>" alt=""></a>
        <?php endif ?>
        <div class="inner-wrap">
          <?php the_title( '<h2>', '</h2>') ?>
          <hr />
          <p class="project-roles">
            <?php
              $terms = get_the_terms($post->ID, 'project-type');
              foreach($terms as $term) {
                rwd_abbr_function($term);
              }
             ?>
          </p>

        </div>
        <div class="portfolio-links">
          <!-- <p><?php // the_tags(); ?></p> -->
          <?php $item_link = get_post_meta( $post->ID, 'portfolio_url', true ); ?>
          <?php if ($item_link != '') : ?>
            <a class="site-link" href="<?php echo $item_link ?>" title="View <?=$title?> Site"><span class="text">Visit Site</span> <i class="icon-external-link"></i></a>
          <?php endif; ?>
          <a href="<?php the_permalink(); ?>" class="site-details" title="View <?=$title?> Project Details"><span class="text">View Details</span> <i class="icon-double-angle-right"></i></a>

        </div>
      </div>
  </article>
<?php endwhile; ?>
