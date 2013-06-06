<?php
/* Template Name: Home Page */
get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php get_template_part('templates/header'); ?>

  <div role="document">
     <?php if ( is_active_sidebar( 'sidebar_jumbotron' ) ) : ?>
    <div id="jumbotron" class="wrap">
            <?php dynamic_sidebar( 'sidebar_jumbotron' ); ?>
   </div>
    <?php endif; ?>
  <div class="wrap">
    <div class="content row">
      <section class="main large-8 columns" role="main">
        <?php get_template_part( 'templates/content-page' );?>
      </section><!-- /.main -->
      <aside class="sidebar large-4 columns" role="complementary">
      </aside><!-- /.sidebar -->
    </div><!-- /.content -->
  </div><!-- /.wrap -->
</div>
  <?php get_template_part('templates/footer'); ?>

</body>
</html>