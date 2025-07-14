<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#main">Skip to content</a>
		<header id="masthead" class="site-header">
			<div class="header-container">
				<!-- Logo Section -->
				<div class="site-logo">
					<a href="<?php echo esc_url(home_url('/')); ?>" rel="home" class="logo-link">
						<?php
						$logo = drakkar_get_logo();
						if ($logo) {
							echo wp_kses_post($logo);
						} else {
							// Fallback to text logo with tagline
							echo '<div class="logo-text">';
							echo '<h1 class="site-title">' . esc_html(get_bloginfo('name')) . '</h1>';
							echo '<span class="tagline">AGRICULTURA DE PRECISÃO</span>';
							echo '</div>';
						}
						?>
					</a>
				</div>

				<!-- Mobile Menu Toggle -->
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" onclick="toggleMobileMenu()" aria-label="Toggle mobile menu">
					<span class="hamburger">
						<span class="line"></span>
						<span class="line"></span>
						<span class="line"></span>
					</span>
				</button>

				<!-- Navigation Menu -->
				<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary navigation">
					<div class="nav-wrapper">
						<?php
						wp_nav_menu(array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'walker'         => new Drakkar_Walker_Nav_Menu(),
							'fallback_cb'    => 'drakkar_fallback_menu',
						));
						?>
						<!-- CTA Button -->
						<a href="#" class="cta-button" role="button">Acesse seu projeto</a>
					</div>
				</nav>
			</div>
		</header><!-- #masthead -->