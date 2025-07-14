<?php

/**
 * The main template file
 *
 * @package Drakkar
 */

get_header();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php
						the_content();

						wp_link_pages(array(
							'before' => '<div class="page-links">' . esc_html__('Pages:', 'drakkar'),
							'after'  => '</div>',
						));
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

			<?php endwhile; ?>

		<?php else : ?>

			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('Nothing here', 'drakkar'); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e('It looks like nothing was found at this location.', 'drakkar'); ?></p>
				</div><!-- .page-content -->
			</section><!-- .no-results -->

		<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>