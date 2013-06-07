<svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='300' height='300'>
<filter id='n' x='0' y='0'>
<feTurbulence type='fractalNoise' baseFrequency='0.7' numOctaves='10' stitchTiles='stitch'/>
</filter>
<rect width='300' height='300' fill='#FF4D56'/>
<rect width='300' height='300' filter="url(#n)" opacity='0.3'/>
</svg>
<header class="banner" role="banner">
  <div class="contain-to-grid">
      <nav class="top-bar nav-main" role="navigation">
          <ul class="title-area">
            <li class="name">
              <a class="brand" href="<?php echo home_url(); ?>/">
              <img height="124" width="125" src="<?php bloginfo('template_directory'); ?>/images/logo.gif" alt="Jason Garner Logo">
              <i class="icon-logo"></i>
              <h1>Jason Garner</h1>
              <h2>Web Designer and Front-End Developer</h2>
              </a>
            </li>
            <li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
          </ul>
          <section class="top-bar-section">
             <?php
              if (has_nav_menu('primary_navigation')) :
                wp_nav_menu( array(
                  'theme_location' => 'primary_navigation',
                  'container' => 'false',
                  'menu_class' => 'right',
                  ''
                  ) );
              endif;
            ?>
          </section>
      </nav>
    </div>
</header>