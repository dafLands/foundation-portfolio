
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
		<?php the_title('<h1 class="page-title">', '</h1><hr />') ?>
  <?php the_content(); ?>
  </article>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>