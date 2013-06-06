<?php
get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php get_template_part('templates/header'); ?>

  <div class="wrap" role="document">
    <?php qt_custom_breadcrumbs(); ?>
    <div class="content portfolio row">
      <section class="main large-12 columns" role="main">
    		<div class="row">
          <?php
            include( TEMPLATEPATH . '/lib/portfolio-meta.php' );
            $temp = $wp_query;
            $wp_query = null;
            $wp_query = new WP_Query();
            if ( get_query_var('paged') ) $paged = get_query_var('paged');
            if ( get_query_var('page') ) $paged = get_query_var('page');

            // Initiate mobile_detect.php
            $detect = new Mobile_Detect();

            if ($detect->isTablet()) {
              $wp_query->query('showposts=6&post_type=portfolio'.'&paged='.$paged);
            } elseif ($detect->isMobile()){
              $wp_query->query('showposts=4&post_type=portfolio'.'&paged='.$paged);
            } else {
              $wp_query->query('showposts=8&post_type=portfolio'.'&paged='.$paged);
            }
           ?>
    			<?php get_template_part( 'templates/content-portfolio-grid' ); ?>
    		</div>
        <?php if ($wp_query->max_num_pages > 1) : ?>
          <nav class="post-nav">
            <ul class="pager">
              <?php if (get_next_posts_link()) : ?>
                <li class="previous"><?php next_posts_link(__('&laquo; <strong>Previous</strong>', 'foundation-portfolio')); ?></li>
              <?php endif; ?>
              <?php if (get_previous_posts_link()) : ?>
                <li class="next"><?php previous_posts_link(__('<strong>Next</strong> &raquo;', 'foundation-portfolio')); ?></li>
              <?php endif; ?>
            </ul>
          </nav>
        <?php endif; ?>
        <?php
          $wp_query = null;
          $wp_query = $temp;  // Reset
        ?>
        <?php // wp_reset_query() ?>
      </section>
      <?php /*
      <aside class="sidebar large-4 columns" role="complementary">
      </aside> */ ?>
    </div>
  </div>

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
