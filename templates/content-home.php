<?php
/**
 * @package foundation_portfolio
 */
?>
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
		<header class="entry-title"><?php the_title('<h1 class="page-title">', '</h1><hr />') ?></header>
  		<div class="entry-content content-columns"><?php the_content(); ?></div>
  </article>
<?php endwhile; ?>