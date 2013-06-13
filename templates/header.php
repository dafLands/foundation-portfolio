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
          <?php if(!getMainMenu('primary_navigation')){
            $backup = $wp_query;
            $wp_query = NULL;
            $wp_query = new WP_Query(array('post_type' => 'post'));
            getMainMenu('primary_navigation');
            $wp_query = $backup;
          } ?>
          </section>
      </nav>
    </div>
</header>