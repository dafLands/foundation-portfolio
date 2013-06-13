<?php
/**
 * @package foundation_portfolio
 */
?>
<?php qt_custom_breadcrumbs(); ?>
<div class="content row">
	<section class="main large-8 columns" role="main">
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
		<header class="entry-title"><?php the_title('<h1 class="page-title">', '</h1><hr />') ?></header>
  		<div class="entry-content content-columns"><?php the_content(); ?></div>
  </article>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
	</section>
</div>