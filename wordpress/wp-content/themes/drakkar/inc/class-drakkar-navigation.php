<?php

/**
 * Drakkar Navigation Manager
 *
 * Unified navigation system for menus and navigation elements
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Drakkar Navigation Manager Class
 */
class Drakkar_Navigation_Manager
{

	/**
	 * Registered navigation menus
	 */
	private $nav_menus = [];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->register_nav_menus();
	}

	/**
	 * Initialize navigation management
	 */
	public function init()
	{
		add_action('wp_nav_menu_item_custom_fields', [$this, 'add_menu_item_fields'], 10, 4);
		add_action('wp_update_nav_menu_item', [$this, 'save_menu_item_fields'], 10, 3);
		add_filter('nav_menu_css_class', [$this, 'add_menu_item_classes'], 10, 3);
		add_filter('nav_menu_link_attributes', [$this, 'add_menu_item_attributes'], 10, 3);

		// Mobile menu toggle
		add_action('wp_footer', [$this, 'mobile_menu_toggle']);

		// Breadcrumbs
		add_action('drakkar_breadcrumbs', [$this, 'display_breadcrumbs']);
	}

	/**
	 * Register navigation menus
	 */
	private function register_nav_menus()
	{
		$this->nav_menus = [
			'primary' => __('Primary Menu', 'drakkar'),
			'footer' => __('Footer Menu', 'drakkar'),
			'mobile' => __('Mobile Menu', 'drakkar'),
			'social' => __('Social Links', 'drakkar'),
		];

		register_nav_menus($this->nav_menus);
	}

	/**
	 * Add custom fields to menu items
	 */
	public function add_menu_item_fields($item_id, $item, $depth, $args)
	{
		$icon_class = get_post_meta($item_id, '_menu_item_icon_class', true);
		$button_style = get_post_meta($item_id, '_menu_item_button_style', true);
		$description = get_post_meta($item_id, '_menu_item_description', true);
?>

		<p class="field-icon-class description description-wide">
			<label for="edit-menu-item-icon-class-<?php echo $item_id; ?>">
				<?php _e('Icon Class', 'drakkar'); ?><br />
				<input type="text"
					id="edit-menu-item-icon-class-<?php echo $item_id; ?>"
					class="widefat code edit-menu-item-icon-class"
					name="menu-item-icon-class[<?php echo $item_id; ?>]"
					value="<?php echo esc_attr($icon_class); ?>" />
				<span class="description"><?php _e('CSS class for icon (e.g., fas fa-home)', 'drakkar'); ?></span>
			</label>
		</p>

		<p class="field-button-style description description-wide">
			<label for="edit-menu-item-button-style-<?php echo $item_id; ?>">
				<?php _e('Button Style', 'drakkar'); ?><br />
				<select id="edit-menu-item-button-style-<?php echo $item_id; ?>"
					name="menu-item-button-style[<?php echo $item_id; ?>]">
					<option value=""><?php _e('Default Link', 'drakkar'); ?></option>
					<option value="primary" <?php selected($button_style, 'primary'); ?>><?php _e('Primary Button', 'drakkar'); ?></option>
					<option value="secondary" <?php selected($button_style, 'secondary'); ?>><?php _e('Secondary Button', 'drakkar'); ?></option>
					<option value="outline" <?php selected($button_style, 'outline'); ?>><?php _e('Outline Button', 'drakkar'); ?></option>
				</select>
			</label>
		</p>

		<p class="field-description description description-wide">
			<label for="edit-menu-item-description-<?php echo $item_id; ?>">
				<?php _e('Description', 'drakkar'); ?><br />
				<textarea id="edit-menu-item-description-<?php echo $item_id; ?>"
					class="widefat edit-menu-item-description"
					rows="3"
					name="menu-item-description[<?php echo $item_id; ?>]"><?php echo esc_textarea($description); ?></textarea>
				<span class="description"><?php _e('Brief description for mega menus', 'drakkar'); ?></span>
			</label>
		</p>

	<?php
	}

	/**
	 * Save custom menu item fields
	 */
	public function save_menu_item_fields($menu_id, $menu_item_db_id, $args)
	{
		if (isset($_POST['menu-item-icon-class'][$menu_item_db_id])) {
			update_post_meta($menu_item_db_id, '_menu_item_icon_class', sanitize_text_field($_POST['menu-item-icon-class'][$menu_item_db_id]));
		}

		if (isset($_POST['menu-item-button-style'][$menu_item_db_id])) {
			update_post_meta($menu_item_db_id, '_menu_item_button_style', sanitize_text_field($_POST['menu-item-button-style'][$menu_item_db_id]));
		}

		if (isset($_POST['menu-item-description'][$menu_item_db_id])) {
			update_post_meta($menu_item_db_id, '_menu_item_description', sanitize_textarea_field($_POST['menu-item-description'][$menu_item_db_id]));
		}
	}

	/**
	 * Add custom classes to menu items
	 */
	public function add_menu_item_classes($classes, $item, $args)
	{
		$button_style = get_post_meta($item->ID, '_menu_item_button_style', true);

		if ($button_style) {
			$classes[] = 'menu-item-button';
			$classes[] = 'menu-item-button--' . $button_style;
		}

		$icon_class = get_post_meta($item->ID, '_menu_item_icon_class', true);
		if ($icon_class) {
			$classes[] = 'menu-item-with-icon';
		}

		return $classes;
	}

	/**
	 * Add custom attributes to menu items
	 */
	public function add_menu_item_attributes($atts, $item, $args)
	{
		$icon_class = get_post_meta($item->ID, '_menu_item_icon_class', true);
		if ($icon_class) {
			$atts['data-icon'] = esc_attr($icon_class);
		}

		$description = get_post_meta($item->ID, '_menu_item_description', true);
		if ($description) {
			$atts['data-description'] = esc_attr($description);
		}

		return $atts;
	}

	/**
	 * Display primary navigation
	 */
	public function display_primary_nav($args = [])
	{
		$defaults = [
			'theme_location' => 'primary',
			'menu_class' => 'primary-nav__menu',
			'container' => 'nav',
			'container_class' => 'primary-navigation',
			'container_id' => 'primary-navigation',
			'walker' => new Drakkar_Walker_Nav_Menu(),
			'fallback_cb' => [$this, 'fallback_menu'],
			'depth' => 3
		];

		$args = wp_parse_args($args, $defaults);

		ob_start();
	?>
		<div class="navigation-wrapper">
			<?php wp_nav_menu($args); ?>
			<button class="mobile-menu-toggle" aria-label="<?php esc_attr_e('Toggle mobile menu', 'drakkar'); ?>">
				<span class="hamburger">
					<span class="hamburger__line"></span>
					<span class="hamburger__line"></span>
					<span class="hamburger__line"></span>
				</span>
			</button>
		</div>
	<?php
		return ob_get_clean();
	}

	/**
	 * Display footer navigation
	 */
	public function display_footer_nav($args = [])
	{
		$defaults = [
			'theme_location' => 'footer',
			'menu_class' => 'footer-nav__menu',
			'container' => 'nav',
			'container_class' => 'footer-navigation',
			'walker' => new Drakkar_Simple_Walker_Nav_Menu(),
			'depth' => 1
		];

		$args = wp_parse_args($args, $defaults);

		return wp_nav_menu(array_merge($args, ['echo' => false]));
	}

	/**
	 * Display social navigation
	 */
	public function display_social_nav($args = [])
	{
		$defaults = [
			'theme_location' => 'social',
			'menu_class' => 'social-nav__menu',
			'container' => 'nav',
			'container_class' => 'social-navigation',
			'walker' => new Drakkar_Social_Walker_Nav_Menu(),
			'depth' => 1,
			'link_before' => '<span class="screen-reader-text">',
			'link_after' => '</span>'
		];

		$args = wp_parse_args($args, $defaults);

		// If no menu assigned, show social links from customizer
		if (!has_nav_menu('social')) {
			return $this->display_customizer_social_links();
		}

		return wp_nav_menu(array_merge($args, ['echo' => false]));
	}

	/**
	 * Display social links from customizer
	 */
	private function display_customizer_social_links()
	{
		$customizer = drakkar_theme()->get_customizer();
		if (!$customizer) {
			return '';
		}

		$social_links = $customizer->get_social_links();

		if (empty($social_links)) {
			return '';
		}

		$target = drakkar_theme()->get_option('social_target', '_blank');

		ob_start();
	?>
		<nav class="social-navigation">
			<ul class="social-nav__menu">
				<?php foreach ($social_links as $network => $url) : ?>
					<li class="menu-item social-item social-item--<?php echo esc_attr($network); ?>">
						<a href="<?php echo esc_url($url); ?>"
							target="<?php echo esc_attr($target); ?>"
							rel="noopener noreferrer"
							aria-label="<?php echo esc_attr(sprintf(__('Follow us on %s', 'drakkar'), ucfirst($network))); ?>">
							<?php echo $this->get_social_icon($network); ?>
							<span class="screen-reader-text"><?php echo esc_html(ucfirst($network)); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php
		return ob_get_clean();
	}

	/**
	 * Get social media icon
	 */
	private function get_social_icon($network)
	{
		$icons = [
			'facebook' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>',
			'twitter' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>',
			'instagram' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>',
			'linkedin' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>',
			'youtube' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>',
			'whatsapp' => '<svg viewBox="0 0 24 24" width="20" height="20"><path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106"/></svg>'
		];

		return $icons[$network] ?? '';
	}

	/**
	 * Display breadcrumbs
	 */
	public function display_breadcrumbs($args = [])
	{
		$defaults = [
			'home_text' => __('Home', 'drakkar'),
			'separator' => '/',
			'show_current' => true,
			'show_home' => true,
			'container_class' => 'breadcrumbs',
			'list_class' => 'breadcrumbs__list'
		];

		$args = wp_parse_args($args, $defaults);

		if (is_front_page()) {
			return '';
		}

		$breadcrumbs = [];

		// Home link
		if ($args['show_home']) {
			$breadcrumbs[] = [
				'url' => home_url('/'),
				'text' => $args['home_text']
			];
		}

		// Build breadcrumb trail
		if (is_category() || is_tag() || is_tax()) {
			$term = get_queried_object();
			$breadcrumbs[] = [
				'url' => get_term_link($term),
				'text' => $term->name
			];
		} elseif (is_archive()) {
			$breadcrumbs[] = [
				'url' => '',
				'text' => get_the_archive_title()
			];
		} elseif (is_search()) {
			$breadcrumbs[] = [
				'url' => '',
				'text' => sprintf(__('Search Results for: %s', 'drakkar'), get_search_query())
			];
		} elseif (is_404()) {
			$breadcrumbs[] = [
				'url' => '',
				'text' => __('Page Not Found', 'drakkar')
			];
		} elseif (is_single()) {
			$post_type = get_post_type();

			if ($post_type === 'post') {
				$categories = get_the_category();
				if (!empty($categories)) {
					$breadcrumbs[] = [
						'url' => get_category_link($categories[0]->term_id),
						'text' => $categories[0]->name
					];
				}
			} elseif ($post_type !== 'page') {
				$post_type_object = get_post_type_object($post_type);
				$breadcrumbs[] = [
					'url' => get_post_type_archive_link($post_type),
					'text' => $post_type_object->labels->name
				];
			}

			if ($args['show_current']) {
				$breadcrumbs[] = [
					'url' => '',
					'text' => get_the_title()
				];
			}
		} elseif (is_page()) {
			$ancestors = get_post_ancestors(get_the_ID());
			$ancestors = array_reverse($ancestors);

			foreach ($ancestors as $ancestor_id) {
				$breadcrumbs[] = [
					'url' => get_permalink($ancestor_id),
					'text' => get_the_title($ancestor_id)
				];
			}

			if ($args['show_current']) {
				$breadcrumbs[] = [
					'url' => '',
					'text' => get_the_title()
				];
			}
		}

		if (empty($breadcrumbs)) {
			return '';
		}

		ob_start();
	?>
		<nav class="<?php echo esc_attr($args['container_class']); ?>" aria-label="<?php esc_attr_e('Breadcrumb navigation', 'drakkar'); ?>">
			<ol class="<?php echo esc_attr($args['list_class']); ?>">
				<?php foreach ($breadcrumbs as $index => $crumb) : ?>
					<li class="breadcrumbs__item">
						<?php if ($crumb['url']) : ?>
							<a href="<?php echo esc_url($crumb['url']); ?>" class="breadcrumbs__link">
								<?php echo esc_html($crumb['text']); ?>
							</a>
						<?php else : ?>
							<span class="breadcrumbs__current"><?php echo esc_html($crumb['text']); ?></span>
						<?php endif; ?>

						<?php if ($index < count($breadcrumbs) - 1) : ?>
							<span class="breadcrumbs__separator" aria-hidden="true"><?php echo esc_html($args['separator']); ?></span>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ol>
		</nav>
	<?php
		return ob_get_clean();
	}

	/**
	 * Fallback menu when no menu is assigned
	 */
	public function fallback_menu()
	{
		$menu_items = [
			'#lavoura-online' => __('Online Farming', 'drakkar'),
			'#agricultura-precisao' => __('Precision Agriculture', 'drakkar'),
			'#historias-sucesso' => __('Success Stories', 'drakkar'),
			'#a-drakkar' => __('About Drakkar', 'drakkar'),
			'#newsletter' => __('Newsletter', 'drakkar')
		];

		ob_start();
	?>
		<nav class="primary-navigation">
			<ul id="primary-menu" class="primary-nav__menu fallback-menu">
				<?php foreach ($menu_items as $url => $label) : ?>
					<li class="menu-item">
						<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</nav>
	<?php
		return ob_get_clean();
	}

	/**
	 * Mobile menu toggle button
	 */
	public function mobile_menu_toggle()
	{
	?>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const toggleButton = document.querySelector('.mobile-menu-toggle');
				const mobileMenu = document.querySelector('#primary-navigation');

				if (toggleButton && mobileMenu) {
					toggleButton.addEventListener('click', function() {
						const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';

						toggleButton.setAttribute('aria-expanded', !isExpanded);
						toggleButton.classList.toggle('is-active');
						mobileMenu.classList.toggle('is-open');

						// Prevent body scroll when menu is open
						document.body.classList.toggle('mobile-menu-open', !isExpanded);
					});
				}
			});
		</script>
<?php
	}

	/**
	 * Get navigation menus
	 */
	public function get_nav_menus()
	{
		return $this->nav_menus;
	}
}

/**
 * Simple Walker for footer navigation
 */
class Drakkar_Simple_Walker_Nav_Menu extends Walker_Nav_Menu
{

	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		// No sub-menus in footer
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		// No sub-menus in footer
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= '<li' . $class_names . '>';
		$output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= "</li>\n";
	}
}

/**
 * Social Walker for social navigation
 */
class Drakkar_Social_Walker_Nav_Menu extends Walker_Nav_Menu
{

	public function start_lvl(&$output, $depth = 0, $args = null)
	{
		// No sub-menus in social navigation
	}

	public function end_lvl(&$output, $depth = 0, $args = null)
	{
		// No sub-menus in social navigation
	}

	public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$classes = empty($item->classes) ? [] : (array) $item->classes;
		$classes[] = 'social-item';

		// Try to detect social network from URL
		$network = $this->detect_social_network($item->url);
		if ($network) {
			$classes[] = 'social-item--' . $network;
		}

		$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
		$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

		$output .= '<li' . $class_names . '>';
		$output .= '<a href="' . esc_url($item->url) . '" target="_blank" rel="noopener noreferrer">';

		if ($network) {
			$output .= $this->get_social_icon($network);
		}

		$output .= esc_html($item->title);
		$output .= '</a>';
	}

	public function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= "</li>\n";
	}

	private function detect_social_network($url)
	{
		$networks = [
			'facebook.com' => 'facebook',
			'twitter.com' => 'twitter',
			'instagram.com' => 'instagram',
			'linkedin.com' => 'linkedin',
			'youtube.com' => 'youtube',
			'wa.me' => 'whatsapp',
			'whatsapp.com' => 'whatsapp'
		];

		foreach ($networks as $domain => $network) {
			if (strpos($url, $domain) !== false) {
				return $network;
			}
		}

		return false;
	}

	private function get_social_icon($network)
	{
		$navigation = drakkar_theme()->get_navigation();
		return $navigation ? $navigation->get_social_icon($network) : '';
	}
}
