
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php get_template_part('templates/header'); ?>

  <div class="wrap index" role="document">
    <?php if ( is_front_page() ) : ?>
<!--     <div class="content row">
      <section class="portfolio large-12 columns">
        <?php // get_template_part( 'templates/content-portfolio' ) ?>
       </section>
    </div> -->
    <?php endif; ?>

        <?php
        if ( is_page( array( 67, 'contact' ) ) )
          get_template_part( 'templates/content-contact' );
        elseif ( is_page() )
          get_template_part( 'templates/content-page' );
        elseif ( is_single() )
          get_template_part( 'templates/content-single' );
        else {
          qt_custom_breadcrumbs(); ?>
          <div class="content row">
            <section class="main large-8 columns" role="main">
              <?php get_template_part( 'templates/content' ); ?>
            </section><!-- /.main -->
            <aside class="sidebar large-4 columns" role="complementary">
            </aside><!-- /.sidebar -->
          </div><!-- /.content -->
        <?php } ?>
  </div><!-- /.wrap -->

  <?php get_template_part('templates/footer'); ?>

</body>
</html>