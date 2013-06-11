
<?php while (have_posts()) : the_post(); ?>
  <div class="large-4 columns">
  	<div class="intro"><?php the_content(); ?></div>
  </div>
  <div class="large-8 columns">
  		<div class="intro"><?php the_content(); ?></div>
  </div>

<?php endwhile; ?>