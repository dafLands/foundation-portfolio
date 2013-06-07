<?php
/* Template Name: Home Page */
get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 7]><div class="alert">Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</div><![endif]-->

  <?php get_template_part('templates/header'); ?>

  <div role="document">
     <?php if ( is_active_sidebar( 'sidebar_jumbotron' ) ) : ?>
    <!-- This SVG will be encoded as a base64 -->
    <!-- image for cross-browser compatibility -->
    <svg xmlns='http://www.w3.org/2000/svg' width='56' height='100'>
    <rect width='56' height='100' fill='#FF4D56'/>
    <path d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='#ff7279' stroke-width='2'/>
    <path d='M28 0L28 34L0 50L0 84L28 100L56 84L56 50L28 34' fill='none' stroke='#ff666d' stroke-width='2'/>
    </svg>
    <div id="demo"><div id="code"></div></div>
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