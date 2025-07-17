<?php

/**
 * Drakkar Customizer Manager
 *
 * Unified customizer settings and controls
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Drakkar Customizer Manager Class
 */
class Drakkar_Customizer_Manager
{

	/**
	 * Initialize customizer management
	 */
	public function init()
	{
		add_action('customize_register', [$this, 'register']);
		add_action('customize_preview_init', [$this, 'preview_scripts']);
		add_action('customize_controls_enqueue_scripts', [$this, 'control_scripts']);
	}

	/**
	 * Register customizer settings
	 */
	public function register($wp_customize)
	{
		// Theme Options Panel
		$this->add_theme_options_panel($wp_customize);

		// Media Settings
		$this->add_media_settings($wp_customize);

		// Layout Settings
		$this->add_layout_settings($wp_customize);

		// Performance Settings
		$this->add_performance_settings($wp_customize);

		// Contact Settings
		$this->add_contact_settings($wp_customize);

		// Social Media Settings
		$this->add_social_media_settings($wp_customize);
	}

	/**
	 * Add main theme options panel
	 */
	private function add_theme_options_panel($wp_customize)
	{
		$wp_customize->add_panel('drakkar_theme_options', [
			'title' => __('Drakkar Theme Options', 'drakkar'),
			'description' => __('Customize your Drakkar theme settings', 'drakkar'),
			'priority' => 30,
		]);
	}

	/**
	 * Add media settings section
	 */
	private function add_media_settings($wp_customize)
	{
		// Media Settings Section
		$wp_customize->add_section('drakkar_media_settings', [
			'title' => __('Media Settings', 'drakkar'),
			'panel' => 'drakkar_theme_options',
			'priority' => 10,
			'description' => __('Configure media and image settings', 'drakkar'),
		]);

		// Default Featured Image
		$wp_customize->add_setting('drakkar_default_featured_image', [
			'default' => '',
			'sanitize_callback' => 'absint',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'drakkar_default_featured_image', [
			'label' => __('Default Featured Image', 'drakkar'),
			'description' => __('Fallback image when posts don\'t have a featured image', 'drakkar'),
			'section' => 'drakkar_media_settings',
			'mime_type' => 'image',
		]));

		// Hero Background Image
		$wp_customize->add_setting('drakkar_hero_background_image', [
			'default' => '',
			'sanitize_callback' => 'absint',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'drakkar_hero_background_image', [
			'label' => __('Hero Background Image', 'drakkar'),
			'description' => __('Main hero section background image', 'drakkar'),
			'section' => 'drakkar_media_settings',
			'mime_type' => 'image',
		]));

		// Image Quality
		$wp_customize->add_setting('drakkar_image_quality', [
			'default' => 85,
			'sanitize_callback' => [$this, 'sanitize_range'],
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_image_quality', [
			'type' => 'range',
			'label' => __('Image Quality', 'drakkar'),
			'description' => __('JPEG compression quality (1-100)', 'drakkar'),
			'section' => 'drakkar_media_settings',
			'input_attrs' => [
				'min' => 1,
				'max' => 100,
				'step' => 1,
			],
		]);

		// Enable WebP
		$wp_customize->add_setting('drakkar_enable_webp', [
			'default' => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_enable_webp', [
			'type' => 'checkbox',
			'label' => __('Enable WebP Generation', 'drakkar'),
			'description' => __('Automatically generate WebP versions of uploaded images', 'drakkar'),
			'section' => 'drakkar_media_settings',
		]);

		// Lazy Loading
		$wp_customize->add_setting('drakkar_lazy_loading', [
			'default' => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_lazy_loading', [
			'type' => 'checkbox',
			'label' => __('Enable Lazy Loading', 'drakkar'),
			'description' => __('Load images only when they become visible', 'drakkar'),
			'section' => 'drakkar_media_settings',
		]);

		// SVG Upload Support
		$wp_customize->add_setting('drakkar_enable_svg_uploads', [
			'default' => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_enable_svg_uploads', [
			'type' => 'checkbox',
			'label' => __('Enable SVG Uploads', 'drakkar'),
			'description' => __('Allow SVG file uploads (use with caution)', 'drakkar'),
			'section' => 'drakkar_media_settings',
		]);
	}

	/**
	 * Add layout settings section
	 */
	private function add_layout_settings($wp_customize)
	{
		// Layout Settings Section
		$wp_customize->add_section('drakkar_layout_settings', [
			'title' => __('Layout Settings', 'drakkar'),
			'panel' => 'drakkar_theme_options',
			'priority' => 20,
		]);

		// Site Layout
		$wp_customize->add_setting('drakkar_site_layout', [
			'default' => 'full-width',
			'sanitize_callback' => [$this, 'sanitize_select'],
			'transport' => 'postMessage'
		]);

		$wp_customize->add_control('drakkar_site_layout', [
			'type' => 'select',
			'label' => __('Site Layout', 'drakkar'),
			'section' => 'drakkar_layout_settings',
			'choices' => [
				'full-width' => __('Full Width', 'drakkar'),
				'boxed' => __('Boxed', 'drakkar'),
				'wide' => __('Wide', 'drakkar'),
			],
		]);

		// Header Style
		$wp_customize->add_setting('drakkar_header_style', [
			'default' => 'default',
			'sanitize_callback' => [$this, 'sanitize_select'],
			'transport' => 'postMessage'
		]);

		$wp_customize->add_control('drakkar_header_style', [
			'type' => 'select',
			'label' => __('Header Style', 'drakkar'),
			'section' => 'drakkar_layout_settings',
			'choices' => [
				'default' => __('Default', 'drakkar'),
				'centered' => __('Centered', 'drakkar'),
				'minimal' => __('Minimal', 'drakkar'),
				'transparent' => __('Transparent', 'drakkar'),
			],
		]);

		// Footer Style
		$wp_customize->add_setting('drakkar_footer_style', [
			'default' => 'default',
			'sanitize_callback' => [$this, 'sanitize_select'],
			'transport' => 'postMessage'
		]);

		$wp_customize->add_control('drakkar_footer_style', [
			'type' => 'select',
			'label' => __('Footer Style', 'drakkar'),
			'section' => 'drakkar_layout_settings',
			'choices' => [
				'default' => __('Default', 'drakkar'),
				'minimal' => __('Minimal', 'drakkar'),
				'columns' => __('Multi-Column', 'drakkar'),
			],
		]);

		// Excerpt Length
		$wp_customize->add_setting('drakkar_excerpt_length', [
			'default' => 20,
			'sanitize_callback' => 'absint',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_excerpt_length', [
			'type' => 'number',
			'label' => __('Excerpt Length', 'drakkar'),
			'description' => __('Number of words in post excerpts', 'drakkar'),
			'section' => 'drakkar_layout_settings',
			'input_attrs' => [
				'min' => 5,
				'max' => 100,
				'step' => 1,
			],
		]);
	}

	/**
	 * Add performance settings section
	 */
	private function add_performance_settings($wp_customize)
	{
		// Performance Settings Section
		$wp_customize->add_section('drakkar_performance_settings', [
			'title' => __('Performance Settings', 'drakkar'),
			'panel' => 'drakkar_theme_options',
			'priority' => 30,
		]);

		// Enable Emojis
		$wp_customize->add_setting('drakkar_enable_emojis', [
			'default' => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_enable_emojis', [
			'type' => 'checkbox',
			'label' => __('Enable WordPress Emojis', 'drakkar'),
			'description' => __('Load WordPress emoji scripts and styles', 'drakkar'),
			'section' => 'drakkar_performance_settings',
		]);

		// Preload Google Fonts
		$wp_customize->add_setting('drakkar_preload_fonts', [
			'default' => true,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_preload_fonts', [
			'type' => 'checkbox',
			'label' => __('Preload Google Fonts', 'drakkar'),
			'description' => __('Improve font loading performance', 'drakkar'),
			'section' => 'drakkar_performance_settings',
		]);

		// Minify CSS
		$wp_customize->add_setting('drakkar_minify_css', [
			'default' => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_minify_css', [
			'type' => 'checkbox',
			'label' => __('Minify CSS', 'drakkar'),
			'description' => __('Automatically minify CSS files', 'drakkar'),
			'section' => 'drakkar_performance_settings',
		]);

		// Defer JavaScript
		$wp_customize->add_setting('drakkar_defer_js', [
			'default' => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_defer_js', [
			'type' => 'checkbox',
			'label' => __('Defer JavaScript', 'drakkar'),
			'description' => __('Defer non-critical JavaScript loading', 'drakkar'),
			'section' => 'drakkar_performance_settings',
		]);
	}

	/**
	 * Add contact settings section
	 */
	private function add_contact_settings($wp_customize)
	{
		// Contact Settings Section
		$wp_customize->add_section('drakkar_contact_settings', [
			'title' => __('Contact Settings', 'drakkar'),
			'panel' => 'drakkar_theme_options',
			'priority' => 40,
		]);

		// WhatsApp Number
		$wp_customize->add_setting('drakkar_whatsapp_number', [
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_whatsapp_number', [
			'type' => 'text',
			'label' => __('WhatsApp Number', 'drakkar'),
			'description' => __('Include country code (e.g., +5511999999999)', 'drakkar'),
			'section' => 'drakkar_contact_settings',
		]);

		// WhatsApp Widget Enable
		$wp_customize->add_setting('drakkar_whatsapp_widget_enable', [
			'default' => false,
			'sanitize_callback' => 'wp_validate_boolean',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_whatsapp_widget_enable', [
			'type' => 'checkbox',
			'label' => __('Enable WhatsApp Widget', 'drakkar'),
			'description' => __('Show floating WhatsApp button', 'drakkar'),
			'section' => 'drakkar_contact_settings',
		]);

		// Contact Email
		$wp_customize->add_setting('drakkar_contact_email', [
			'default' => get_option('admin_email'),
			'sanitize_callback' => 'sanitize_email',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_contact_email', [
			'type' => 'email',
			'label' => __('Contact Email', 'drakkar'),
			'description' => __('Email address for contact forms', 'drakkar'),
			'section' => 'drakkar_contact_settings',
		]);

		// Company Address
		$wp_customize->add_setting('drakkar_company_address', [
			'default' => '',
			'sanitize_callback' => 'sanitize_textarea_field',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_company_address', [
			'type' => 'textarea',
			'label' => __('Company Address', 'drakkar'),
			'section' => 'drakkar_contact_settings',
		]);

		// Phone Number
		$wp_customize->add_setting('drakkar_phone_number', [
			'default' => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_phone_number', [
			'type' => 'text',
			'label' => __('Phone Number', 'drakkar'),
			'section' => 'drakkar_contact_settings',
		]);
	}

	/**
	 * Add social media settings section
	 */
	private function add_social_media_settings($wp_customize)
	{
		// Social Media Settings Section
		$wp_customize->add_section('drakkar_social_settings', [
			'title' => __('Social Media', 'drakkar'),
			'panel' => 'drakkar_theme_options',
			'priority' => 50,
		]);

		$social_networks = [
			'facebook' => __('Facebook', 'drakkar'),
			'twitter' => __('Twitter', 'drakkar'),
			'instagram' => __('Instagram', 'drakkar'),
			'linkedin' => __('LinkedIn', 'drakkar'),
			'youtube' => __('YouTube', 'drakkar'),
			'whatsapp' => __('WhatsApp', 'drakkar'),
		];

		foreach ($social_networks as $network => $label) {
			$wp_customize->add_setting("drakkar_social_{$network}", [
				'default' => '',
				'sanitize_callback' => 'esc_url_raw',
				'transport' => 'refresh'
			]);

			$wp_customize->add_control("drakkar_social_{$network}", [
				'type' => 'url',
				'label' => $label . ' ' . __('URL', 'drakkar'),
				'section' => 'drakkar_social_settings',
			]);
		}

		// Social Links Target
		$wp_customize->add_setting('drakkar_social_target', [
			'default' => '_blank',
			'sanitize_callback' => [$this, 'sanitize_select'],
			'transport' => 'refresh'
		]);

		$wp_customize->add_control('drakkar_social_target', [
			'type' => 'select',
			'label' => __('Social Links Target', 'drakkar'),
			'section' => 'drakkar_social_settings',
			'choices' => [
				'_self' => __('Same Window', 'drakkar'),
				'_blank' => __('New Window', 'drakkar'),
			],
		]);
	}

	/**
	 * Enqueue customizer preview scripts
	 */
	public function preview_scripts()
	{
		wp_enqueue_script(
			'drakkar-customizer-preview',
			drakkar_theme()->get_theme_uri() . '/assets/js/admin/customizer-preview.js',
			['customize-preview'],
			drakkar_theme()->get_version(),
			true
		);
	}

	/**
	 * Enqueue customizer control scripts
	 */
	public function control_scripts()
	{
		wp_enqueue_script(
			'drakkar-customizer-controls',
			drakkar_theme()->get_theme_uri() . '/assets/js/admin/customizer-controls.js',
			['customize-controls'],
			drakkar_theme()->get_version(),
			true
		);

		wp_enqueue_style(
			'drakkar-customizer-controls',
			drakkar_theme()->get_theme_uri() . '/assets/css/admin/customizer.css',
			['customize-controls'],
			drakkar_theme()->get_version()
		);
	}

	/**
	 * Sanitize select input
	 */
	public function sanitize_select($input, $setting)
	{
		$control = $setting->manager->get_control($setting->id);

		if ($control && isset($control->choices) && array_key_exists($input, $control->choices)) {
			return $input;
		}

		return $setting->default;
	}

	/**
	 * Sanitize range input
	 */
	public function sanitize_range($input, $min = 1, $max = 100, $step = 1)
	{
		$input = absint($input);

		if ($input < $min) {
			return $min;
		} elseif ($input > $max) {
			return $max;
		} else {
			return $input;
		}
	}

	/**
	 * Get theme option with fallback
	 */
	public function get_option($option, $default = '')
	{
		return get_theme_mod('drakkar_' . $option, $default);
	}

	/**
	 * Get all social media links
	 */
	public function get_social_links()
	{
		$social_networks = [
			'facebook',
			'twitter',
			'instagram',
			'linkedin',
			'youtube',
			'whatsapp'
		];

		$links = [];

		foreach ($social_networks as $network) {
			$url = $this->get_option("social_{$network}");
			if (!empty($url)) {
				$links[$network] = $url;
			}
		}

		return $links;
	}
}
