<?php

/**
 * Front Page Template
 *
 * Template for the front page (homepage) of the Drakkar website
 * Features hero section and statistics as the main landing area
 *
 * @package Drakkar
 */

get_header();
?>

<!-- Hero Section -->
<?php get_template_part('template-parts/hero-main'); ?>

<!-- Statistics Section -->
<?php get_template_part('template-parts/hero-statistics'); ?>

<!-- Hero Expertise Section -->
<?php get_template_part('template-parts/hero-expertise'); ?>

<!-- Hero Big Data Section -->
<?php get_template_part('template-parts/hero-big-data'); ?>

<!-- Analytics Section -->
<?php get_template_part('template-parts/section-analytics'); ?>

<!-- Agriculture Section -->
<?php get_template_part('template-parts/section-agriculture'); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

		<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

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

			<!-- Default content if no posts -->
			<section class="no-results not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e('Nothing here', 'drakkar'); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e('It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'drakkar'); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .no-results -->

		<?php endif; ?>

		<!-- Additional sections can be added here -->
		<section id="plataforma" class="platform-section">
			<div class="container">
				<h2>Nossa Plataforma de Agricultura de Precisão</h2>
				<p>Conheça as soluções tecnológicas que estão revolucionando a agricultura moderna.</p>
				<!-- Platform content would go here -->
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
