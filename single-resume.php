<?php
get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php get_template_part( 'templates/header' ); ?>

  <div class="wrap" role="document">
    <?php qt_custom_breadcrumbs(); ?>
    <div <?php post_class('content'); ?>>
      <section class="main row resume" role="main">
			<?php get_template_part( 'templates/content-resume' ); ?>
      </section>
      <?php /*
      <aside class="sidebar large-4 columns" role="complementary">
      </aside> */ ?>
    </div>
  </div>

  <?php get_template_part('templates/footer'); ?>

</body>
</html>
