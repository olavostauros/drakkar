<?php

/**
 * Drakkar Components Manager
 *
 * Unified component system for reusable template parts and UI elements
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Drakkar Components Manager Class
 */
class Drakkar_Components_Manager
{

	/**
	 * Registered components
	 */
	private $components = [];

	/**
	 * Component cache
	 */
	private $cache = [];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->register_default_components();
	}

	/**
	 * Initialize component management
	 */
	public function init()
	{
		add_action('wp_head', [$this, 'add_component_styles'], 15);
		add_action('wp_footer', [$this, 'add_component_scripts'], 5);

		// Register custom blocks if Gutenberg is active
		if (function_exists('register_block_type')) {
			add_action('init', [$this, 'register_blocks']);
		}
	}

	/**
	 * Register default components
	 */
	private function register_default_components()
	{
		$this->components = [
			'hero' => [
				'callback' => [$this, 'hero_section'],
				'styles' => ['css/components/hero.css'],
				'scripts' => ['js/components/hero.js']
			],
			'cta-button' => [
				'callback' => [$this, 'cta_button'],
				'styles' => ['css/components/buttons.css'],
				'scripts' => []
			],
			'statistics' => [
				'callback' => [$this, 'statistics_section'],
				'styles' => ['css/components/statistics.css'],
				'scripts' => ['js/components/statistics.js']
			],
			'responsive-image' => [
				'callback' => [$this, 'responsive_image'],
				'styles' => ['css/components/images.css'],
				'scripts' => ['js/components/lazy-loading.js']
			],
			'whatsapp-widget' => [
				'callback' => [$this, 'whatsapp_widget'],
				'styles' => ['css/components/whatsapp-widget.css'],
				'scripts' => ['js/components/whatsapp-widget.js']
			],
			'contact-form' => [
				'callback' => [$this, 'contact_form'],
				'styles' => ['css/components/contact-form.css'],
				'scripts' => ['js/components/contact-form.js']
			],
			'navigation' => [
				'callback' => [$this, 'navigation_menu'],
				'styles' => ['css/components/navigation.css'],
				'scripts' => ['js/components/navigation.js']
			],
			'card' => [
				'callback' => [$this, 'content_card'],
				'styles' => ['css/components/cards.css'],
				'scripts' => []
			]
		];
	}

	/**
	 * Generate hero section component
	 */
	public function hero_section($args = [])
	{
		$defaults = [
			'type' => 'main',
			'background' => '',
			'title' => '',
			'subtitle' => '',
			'description' => '',
			'cta' => [],
			'video' => '',
			'overlay' => true,
			'statistics' => [],
			'badge' => '',
			'alignment' => 'center',
			'classes' => [],
			'custom_css' => ''
		];

		$args = wp_parse_args($args, $defaults);

		// Sanitize inputs
		$title = wp_kses_post($args['title']);
		$subtitle = wp_kses_post($args['subtitle']);
		$description = wp_kses_post($args['description']);
		$badge = esc_html($args['badge']);
		$background_url = esc_url($args['background']);
		$video_url = esc_url($args['video']);

		// Build CSS classes
		$hero_classes = ['hero', 'component-hero'];
		$hero_classes[] = 'hero--' . sanitize_html_class($args['type']);
		$hero_classes[] = 'hero--align-' . sanitize_html_class($args['alignment']);

		if (!empty($args['classes'])) {
			$hero_classes = array_merge($hero_classes, (array) $args['classes']);
		}

		$content_classes = ['hero__content'];

		ob_start();
?>

		<section class="<?php echo esc_attr(implode(' ', $hero_classes)); ?>"
			data-component="hero"
			<?php if ($background_url) : ?>style="background-image: url('<?php echo $background_url; ?>');" <?php endif; ?>>

			<?php if ($video_url) : ?>
				<div class="hero__video-container">
					<video class="hero__video" autoplay muted loop playsinline>
						<source src="<?php echo $video_url; ?>" type="video/mp4">
						<?php _e('Your browser does not support the video tag.', 'drakkar'); ?>
					</video>
				</div>
			<?php endif; ?>

			<?php if ($args['overlay']) : ?>
				<div class="hero__overlay"></div>
			<?php endif; ?>

			<div class="<?php echo esc_attr(implode(' ', $content_classes)); ?>">

				<?php if ($badge) : ?>
					<span class="hero__badge"><?php echo $badge; ?></span>
				<?php endif; ?>

				<?php if ($title) : ?>
					<h1 class="hero__title"><?php echo $title; ?></h1>
				<?php endif; ?>

				<?php if ($subtitle) : ?>
					<h2 class="hero__subtitle"><?php echo $subtitle; ?></h2>
				<?php endif; ?>

				<?php if ($description) : ?>
					<div class="hero__description"><?php echo $description; ?></div>
				<?php endif; ?>

				<?php if (!empty($args['cta'])) : ?>
					<div class="hero__cta">
						<?php echo $this->cta_button($args['cta']); ?>
					</div>
				<?php endif; ?>

			</div>

			<?php if (!empty($args['statistics'])) : ?>
				<?php echo $this->statistics_section($args['statistics']); ?>
			<?php endif; ?>

			<?php if ($args['custom_css']) : ?>
				<style>
					<?php echo esc_html($args['custom_css']); ?>
				</style>
			<?php endif; ?>

		</section>

	<?php
		return ob_get_clean();
	}

	/**
	 * Generate CTA button component
	 */
	public function cta_button($args = [])
	{
		$defaults = [
			'text' => __('Click Here', 'drakkar'),
			'url' => '#',
			'style' => 'primary',
			'size' => 'medium',
			'target' => '_self',
			'icon' => '',
			'classes' => [],
			'attributes' => []
		];

		$args = wp_parse_args($args, $defaults);

		$button_classes = ['btn', 'component-button'];
		$button_classes[] = 'btn--' . sanitize_html_class($args['style']);
		$button_classes[] = 'btn--' . sanitize_html_class($args['size']);

		if (!empty($args['classes'])) {
			$button_classes = array_merge($button_classes, (array) $args['classes']);
		}

		$attributes = [
			'href' => esc_url($args['url']),
			'class' => esc_attr(implode(' ', $button_classes)),
			'target' => esc_attr($args['target'])
		];

		if (!empty($args['attributes'])) {
			$attributes = array_merge($attributes, $args['attributes']);
		}

		$attr_string = '';
		foreach ($attributes as $key => $value) {
			$attr_string .= sprintf(' %s="%s"', esc_attr($key), esc_attr($value));
		}

		ob_start();
	?>

		<a<?php echo $attr_string; ?> data-component="cta-button">
			<?php if ($args['icon']) : ?>
				<span class="btn__icon"><?php echo wp_kses_post($args['icon']); ?></span>
			<?php endif; ?>
			<span class="btn__text"><?php echo esc_html($args['text']); ?></span>
			</a>

		<?php
		return ob_get_clean();
	}

	/**
	 * Generate statistics section
	 */
	public function statistics_section($statistics = [])
	{
		if (empty($statistics)) {
			return '';
		}

		ob_start();
		?>

			<div class="statistics-section component-statistics" data-component="statistics">
				<div class="statistics-section__container">
					<?php foreach ($statistics as $stat) : ?>
						<div class="statistic">
							<div class="statistic__number" data-target="<?php echo esc_attr($stat['number']); ?>">
								<?php echo esc_html($stat['number']); ?>
							</div>
							<div class="statistic__label">
								<?php echo esc_html($stat['label']); ?>
							</div>
							<?php if (!empty($stat['description'])) : ?>
								<div class="statistic__description">
									<?php echo esc_html($stat['description']); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<?php
			return ob_get_clean();
		}

		/**
		 * Generate responsive image component
		 */
		public function responsive_image($args = [])
		{
			$defaults = [
				'src' => '',
				'attachment_id' => 0,
				'size' => 'full',
				'alt' => '',
				'caption' => '',
				'classes' => [],
				'lazy' => true,
				'fallback' => ''
			];

			$args = wp_parse_args($args, $defaults);

			// Use media manager for image handling
			$media = drakkar_theme()->get_media();

			if ($args['attachment_id']) {
				return $media->get_responsive_image($args['attachment_id'], $args['size'], [
					'class' => implode(' ', array_merge(['component-image'], (array) $args['classes'])),
					'alt' => $args['alt'],
					'loading' => $args['lazy'] ? 'lazy' : 'eager'
				]);
			} elseif ($args['src']) {
				$img_classes = array_merge(['component-image'], (array) $args['classes']);

				ob_start();
			?>
				<img src="<?php echo esc_url($args['src']); ?>"
					alt="<?php echo esc_attr($args['alt']); ?>"
					class="<?php echo esc_attr(implode(' ', $img_classes)); ?>"
					<?php if ($args['lazy']) : ?>loading="lazy" <?php endif; ?>
					data-component="responsive-image" />
			<?php
				return ob_get_clean();
			}

			return '';
		}

		/**
		 * Generate WhatsApp widget component
		 */
		public function whatsapp_widget($args = [])
		{
			$defaults = [
				'phone' => drakkar_theme()->get_option('whatsapp_number', ''),
				'message' => __('Hello! I would like to know more about your services.', 'drakkar'),
				'position' => 'bottom-right',
				'show_on_mobile' => true,
				'show_on_desktop' => true
			];

			$args = wp_parse_args($args, $defaults);

			if (empty($args['phone'])) {
				return '';
			}

			$widget_classes = ['whatsapp-widget', 'component-whatsapp'];
			$widget_classes[] = 'whatsapp-widget--' . sanitize_html_class($args['position']);

			$whatsapp_url = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $args['phone']);
			if (!empty($args['message'])) {
				$whatsapp_url .= '?text=' . urlencode($args['message']);
			}

			ob_start();
			?>

			<div class="<?php echo esc_attr(implode(' ', $widget_classes)); ?>"
				data-component="whatsapp-widget"
				<?php if (!$args['show_on_mobile']) : ?>data-hide-mobile="true" <?php endif; ?>
				<?php if (!$args['show_on_desktop']) : ?>data-hide-desktop="true" <?php endif; ?>>

				<a href="<?php echo esc_url($whatsapp_url); ?>"
					target="_blank"
					rel="noopener noreferrer"
					class="whatsapp-widget__button"
					aria-label="<?php esc_attr_e('Contact us on WhatsApp', 'drakkar'); ?>">

					<svg class="whatsapp-widget__icon" viewBox="0 0 24 24" width="24" height="24">
						<path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.106" />
					</svg>

					<span class="whatsapp-widget__text">
						<?php esc_html_e('WhatsApp', 'drakkar'); ?>
					</span>
				</a>
			</div>

		<?php
			return ob_get_clean();
		}

		/**
		 * Generate contact form component
		 */
		public function contact_form($args = [])
		{
			$defaults = [
				'id' => 'contact-form',
				'fields' => ['name', 'email', 'subject', 'message'],
				'submit_text' => __('Send Message', 'drakkar'),
				'success_message' => __('Thank you for your message!', 'drakkar'),
				'error_message' => __('Please fill out all required fields.', 'drakkar')
			];

			$args = wp_parse_args($args, $defaults);

			ob_start();
		?>

			<form id="<?php echo esc_attr($args['id']); ?>"
				class="contact-form component-contact-form"
				data-component="contact-form"
				method="post"
				action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

				<input type="hidden" name="action" value="drakkar_contact_form" />
				<?php wp_nonce_field('drakkar_contact_form', 'contact_nonce'); ?>

				<?php foreach ($args['fields'] as $field) : ?>
					<?php echo $this->render_form_field($field); ?>
				<?php endforeach; ?>

				<div class="contact-form__submit">
					<button type="submit" class="btn btn--primary">
						<?php echo esc_html($args['submit_text']); ?>
					</button>
				</div>

				<div class="contact-form__messages">
					<div class="contact-form__success" style="display: none;">
						<?php echo esc_html($args['success_message']); ?>
					</div>
					<div class="contact-form__error" style="display: none;">
						<?php echo esc_html($args['error_message']); ?>
					</div>
				</div>
			</form>

		<?php
			return ob_get_clean();
		}

		/**
		 * Render individual form field
		 */
		private function render_form_field($field)
		{
			$field_config = [
				'name' => [
					'type' => 'text',
					'label' => __('Name', 'drakkar'),
					'required' => true
				],
				'email' => [
					'type' => 'email',
					'label' => __('Email', 'drakkar'),
					'required' => true
				],
				'subject' => [
					'type' => 'text',
					'label' => __('Subject', 'drakkar'),
					'required' => false
				],
				'message' => [
					'type' => 'textarea',
					'label' => __('Message', 'drakkar'),
					'required' => true
				]
			];

			if (!isset($field_config[$field])) {
				return '';
			}

			$config = $field_config[$field];

			ob_start();
		?>

			<div class="contact-form__field">
				<label for="<?php echo esc_attr($field); ?>" class="contact-form__label">
					<?php echo esc_html($config['label']); ?>
					<?php if ($config['required']) : ?>
						<span class="required">*</span>
					<?php endif; ?>
				</label>

				<?php if ($config['type'] === 'textarea') : ?>
					<textarea
						id="<?php echo esc_attr($field); ?>"
						name="<?php echo esc_attr($field); ?>"
						class="contact-form__textarea"
						<?php if ($config['required']) : ?>required<?php endif; ?>
						rows="5"></textarea>
				<?php else : ?>
					<input
						type="<?php echo esc_attr($config['type']); ?>"
						id="<?php echo esc_attr($field); ?>"
						name="<?php echo esc_attr($field); ?>"
						class="contact-form__input"
						<?php if ($config['required']) : ?>required<?php endif; ?> />
				<?php endif; ?>
			</div>

		<?php
			return ob_get_clean();
		}

		/**
		 * Generate navigation menu component
		 */
		public function navigation_menu($args = [])
		{
			$defaults = [
				'theme_location' => 'primary',
				'menu_class' => 'nav-menu',
				'container' => 'nav',
				'container_class' => 'primary-navigation component-navigation',
				'walker' => new Drakkar_Walker_Nav_Menu(),
				'fallback_cb' => [$this, 'fallback_menu']
			];

			$args = wp_parse_args($args, $defaults);

			return wp_nav_menu(array_merge($args, ['echo' => false]));
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
			<ul id="primary-menu" class="nav-menu fallback-menu">
				<?php foreach ($menu_items as $url => $label) : ?>
					<li class="menu-item">
						<a href="<?php echo esc_url($url); ?>"><?php echo esc_html($label); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php
			return ob_get_clean();
		}

		/**
		 * Generate content card component
		 */
		public function content_card($args = [])
		{
			$defaults = [
				'title' => '',
				'content' => '',
				'image' => '',
				'link' => '',
				'link_text' => __('Read More', 'drakkar'),
				'style' => 'default',
				'classes' => []
			];

			$args = wp_parse_args($args, $defaults);

			$card_classes = ['content-card', 'component-card'];
			$card_classes[] = 'content-card--' . sanitize_html_class($args['style']);

			if (!empty($args['classes'])) {
				$card_classes = array_merge($card_classes, (array) $args['classes']);
			}

			ob_start();
		?>

			<div class="<?php echo esc_attr(implode(' ', $card_classes)); ?>" data-component="card">

				<?php if ($args['image']) : ?>
					<div class="content-card__image">
						<?php echo $this->responsive_image(['src' => $args['image'], 'alt' => $args['title']]); ?>
					</div>
				<?php endif; ?>

				<div class="content-card__content">

					<?php if ($args['title']) : ?>
						<h3 class="content-card__title"><?php echo wp_kses_post($args['title']); ?></h3>
					<?php endif; ?>

					<?php if ($args['content']) : ?>
						<div class="content-card__text"><?php echo wp_kses_post($args['content']); ?></div>
					<?php endif; ?>

					<?php if ($args['link']) : ?>
						<div class="content-card__action">
							<?php echo $this->cta_button([
								'text' => $args['link_text'],
								'url' => $args['link'],
								'style' => 'secondary',
								'size' => 'small'
							]); ?>
						</div>
					<?php endif; ?>

				</div>
			</div>

	<?php
			return ob_get_clean();
		}

		/**
		 * Render component by name
		 */
		public function render($component_name, $args = [])
		{
			if (!isset($this->components[$component_name])) {
				return '';
			}

			$component = $this->components[$component_name];

			if (isset($component['callback']) && is_callable($component['callback'])) {
				return call_user_func($component['callback'], $args);
			}

			return '';
		}

		/**
		 * Check if component exists
		 */
		public function has_component($component_name)
		{
			return isset($this->components[$component_name]);
		}

		/**
		 * Register custom Gutenberg blocks
		 */
		public function register_blocks()
		{
			foreach ($this->components as $name => $component) {
				register_block_type('drakkar/' . $name, [
					'render_callback' => $component['callback']
				]);
			}
		}

		/**
		 * Add component-specific styles
		 */
		public function add_component_styles()
		{
			// This would be handled by the asset manager
			// Implementation depends on which components are actually used on the page
		}

		/**
		 * Add component-specific scripts
		 */
		public function add_component_scripts()
		{
			// This would be handled by the asset manager
			// Implementation depends on which components are actually used on the page
		}

		/**
		 * Get registered components
		 */
		public function get_components()
		{
			return $this->components;
		}

		/**
		 * Register new component
		 */
		public function register_component($name, $config)
		{
			$this->components[$name] = $config;
		}
	}

	/**
	 * Custom Walker for Navigation Menu
	 */
	class Drakkar_Walker_Nav_Menu extends Walker_Nav_Menu
	{

		public function start_lvl(&$output, $depth = 0, $args = null)
		{
			$indent = str_repeat("\t", $depth);
			$output .= "\n$indent<ul class=\"sub-menu\">\n";
		}

		public function end_lvl(&$output, $depth = 0, $args = null)
		{
			$indent = str_repeat("\t", $depth);
			$output .= "$indent</ul>\n";
		}

		public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
		{
			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$classes = empty($item->classes) ? [] : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
			$class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			$id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
			$id = $id ? ' id="' . esc_attr($id) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
			$attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
			$attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';

			$item_output = isset($args->before) ? $args->before : '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
			$item_output .= '</a>';
			$item_output .= isset($args->after) ? $args->after : '';

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}

		public function end_el(&$output, $item, $depth = 0, $args = null)
		{
			$output .= "</li>\n";
		}
	}
