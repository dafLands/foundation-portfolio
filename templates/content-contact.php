<?php
/**
 * @package foundation_portfolio
 */
?>
<?php qt_custom_breadcrumbs(); ?>
<div class="content row">
	<section class="main large-6 columns" role="main">
<?php while (have_posts()) : the_post(); ?>
  <article id="contact-page" <?php post_class(); ?>>
		<?php the_title('<h1 class="page-title">', '</h1><hr />') ?>
		  <?php the_content(); ?>
		  <?php if( is_active_sidebar( 'sidebar_contact_form' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar_contact_form' ); ?>
		  <?php endif; ?>
  </article>
  <?php wp_link_pages(array('before' => '<nav class="pagination">', 'after' => '</nav>')); ?>
<?php endwhile; ?>
	</section>
</div>