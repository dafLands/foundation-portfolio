
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
		<header><?php the_title('<h1 class="page-title">', '</h1><hr />') ?></header>
  		<div class="entry-content content-columns"><?php the_content(); ?></div>
  </article>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>