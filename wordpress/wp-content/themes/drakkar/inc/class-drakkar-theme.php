<?php

/**
 * Drakkar Theme Main Class
 *
 * Central hub for all theme functionality - unified architecture
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Main Drakkar Theme Class
 *
 * Centralizes all theme functionality into a single, organized class system
 */
class Drakkar_Theme
{

	/**
	 * Theme version
	 */
	const VERSION = '3.0.0';

	/**
	 * Theme text domain
	 */
	const TEXT_DOMAIN = 'drakkar';

	/**
	 * Instance of this class
	 */
	private static $instance = null;

	/**
	 * Theme directory path
	 */
	private $theme_dir;

	/**
	 * Theme directory URI
	 */
	private $theme_uri;

	/**
	 * Asset manager instance
	 */
	private $assets;

	/**
	 * Media manager instance
	 */
	private $media;

	/**
	 * Components manager instance
	 */
	private $components;

	/**
	 * Customizer manager instance
	 */
	private $customizer;

	/**
	 * Navigation manager instance
	 */
	private $navigation;

	/**
	 * Get singleton instance
	 */
	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	private function __construct()
	{
		$this->theme_dir = get_template_directory();
		$this->theme_uri = get_template_directory_uri();

		$this->init();
	}

	/**
	 * Initialize theme
	 */
	private function init()
	{
		// Load dependencies
		$this->load_dependencies();

		// Initialize managers
		$this->init_managers();

		// Setup theme
		add_action('after_setup_theme', [$this, 'setup_theme']);
		add_action('init', [$this, 'init_theme']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
		add_action('customize_register', [$this, 'customize_register']);

		// Setup filters and hooks
		$this->setup_filters();
		$this->setup_hooks();
	}

	/**
	 * Load required files
	 */
	private function load_dependencies()
	{
		$includes = [
			'inc/class-drakkar-assets.php',
			'inc/class-drakkar-media.php',
			'inc/class-drakkar-components.php',
			'inc/class-drakkar-customizer.php',
			'inc/class-drakkar-navigation.php'
		];

		foreach ($includes as $file) {
			$file_path = $this->theme_dir . '/' . $file;
			if (file_exists($file_path)) {
				require_once $file_path;
			}
		}
	}

	/**
	 * Initialize manager classes
	 */
	private function init_managers()
	{
		if (class_exists('Drakkar_Assets_Manager')) {
			$this->assets = new Drakkar_Assets_Manager();
		}

		if (class_exists('Drakkar_Media_Manager')) {
			$this->media = new Drakkar_Media_Manager();
		}

		if (class_exists('Drakkar_Components_Manager')) {
			$this->components = new Drakkar_Components_Manager();
		}

		if (class_exists('Drakkar_Customizer_Manager')) {
			$this->customizer = new Drakkar_Customizer_Manager();
		}

		if (class_exists('Drakkar_Navigation_Manager')) {
			$this->navigation = new Drakkar_Navigation_Manager();
		}
	}

	/**
	 * Theme setup
	 */
	public function setup_theme()
	{
		// Load theme textdomain
		load_theme_textdomain(self::TEXT_DOMAIN, $this->theme_dir . '/languages');

		// Theme supports
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'navigation-widgets',
		]);
		add_theme_support('responsive-embeds');
		add_theme_support('wp-block-styles');
		add_theme_support('align-wide');
		add_theme_support('editor-styles');

		// Custom logo support
		add_theme_support('custom-logo', [
			'height'         => 100,
			'width'          => 300,
			'flex-height'    => true,
			'flex-width'     => true,
			'header-text'    => ['site-title', 'site-description'],
			'unlink-homepage-logo' => false,
		]);

		// Navigation menus
		register_nav_menus([
			'primary' => __('Primary Menu', self::TEXT_DOMAIN),
			'footer'  => __('Footer Menu', self::TEXT_DOMAIN),
			'mobile'  => __('Mobile Menu', self::TEXT_DOMAIN),
		]);

		// Custom image sizes
		$this->setup_image_sizes();
	}

	/**
	 * Initialize theme features
	 */
	public function init_theme()
	{
		// Initialize managers
		if ($this->assets) {
			$this->assets->init();
		}

		if ($this->media) {
			$this->media->init();
		}

		if ($this->components) {
			$this->components->init();
		}

		if ($this->navigation) {
			$this->navigation->init();
		}
	}

	/**
	 * Enqueue theme assets
	 */
	public function enqueue_assets()
	{
		if ($this->assets) {
			$this->assets->enqueue();
		}
	}

	/**
	 * Register customizer settings
	 */
	public function customize_register($wp_customize)
	{
		if ($this->customizer) {
			$this->customizer->register($wp_customize);
		}
	}

	/**
	 * Setup custom image sizes
	 */
	private function setup_image_sizes()
	{
		$image_sizes = [
			'drakkar-thumbnail' => [150, 150, true],
			'drakkar-small'     => [300, 200, true],
			'drakkar-medium'    => [600, 400, true],
			'drakkar-large'     => [1200, 800, true],
			'drakkar-hero'      => [1920, 1080, true],
			'drakkar-square'    => [500, 500, true],
		];

		foreach ($image_sizes as $name => $config) {
			add_image_size($name, $config[0], $config[1], $config[2]);
		}

		// Set default thumbnail size
		set_post_thumbnail_size(1200, 800, true);
	}

	/**
	 * Setup theme filters
	 */
	private function setup_filters()
	{
		// Image quality
		add_filter('wp_editor_set_quality', [$this, 'image_quality']);
		add_filter('jpeg_quality', [$this, 'image_quality']);

		// Image size names
		add_filter('image_size_names_choose', [$this, 'custom_image_sizes']);

		// Excerpt length
		add_filter('excerpt_length', [$this, 'excerpt_length']);

		// Body class
		add_filter('body_class', [$this, 'body_classes']);

		// Resource hints
		add_filter('wp_resource_hints', [$this, 'resource_hints'], 10, 2);
	}

	/**
	 * Setup theme hooks
	 */
	private function setup_hooks()
	{
		// Head optimizations
		add_action('wp_head', [$this, 'viewport_meta'], 1);
		add_action('wp_head', [$this, 'preload_assets'], 2);

		// Clean up wp_head
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_shortlink_wp_head');

		// Security headers
		add_action('wp_head', [$this, 'security_headers'], 0);
	}

	/**
	 * Configure image quality
	 */
	public function image_quality($quality)
	{
		return $this->get_option('image_quality', 85);
	}

	/**
	 * Add custom image sizes to media library
	 */
	public function custom_image_sizes($sizes)
	{
		return array_merge($sizes, [
			'drakkar-thumbnail' => __('Drakkar Thumbnail', self::TEXT_DOMAIN),
			'drakkar-small'     => __('Drakkar Small', self::TEXT_DOMAIN),
			'drakkar-medium'    => __('Drakkar Medium', self::TEXT_DOMAIN),
			'drakkar-large'     => __('Drakkar Large', self::TEXT_DOMAIN),
			'drakkar-hero'      => __('Drakkar Hero', self::TEXT_DOMAIN),
			'drakkar-square'    => __('Drakkar Square', self::TEXT_DOMAIN),
		]);
	}

	/**
	 * Customize excerpt length
	 */
	public function excerpt_length($length)
	{
		return $this->get_option('excerpt_length', 20);
	}

	/**
	 * Add custom body classes
	 */
	public function body_classes($classes)
	{
		// Add theme version class
		$classes[] = 'drakkar-theme';
		$classes[] = 'drakkar-v' . str_replace('.', '-', self::VERSION);

		// Add page template class
		if (is_page_template()) {
			$template = get_page_template_slug();
			$classes[] = 'template-' . sanitize_html_class(str_replace('.php', '', basename($template)));
		}

		return $classes;
	}

	/**
	 * Add viewport meta tag
	 */
	public function viewport_meta()
	{
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
	}

	/**
	 * Preload critical assets
	 */
	public function preload_assets()
	{
		if ($this->assets) {
			$this->assets->preload_critical();
		}
	}

	/**
	 * Add security headers
	 */
	public function security_headers()
	{
		if (!is_admin()) {
			echo '<meta http-equiv="X-Content-Type-Options" content="nosniff">' . "\n";
			echo '<meta http-equiv="X-Frame-Options" content="SAMEORIGIN">' . "\n";
		}
	}

	/**
	 * Add resource hints
	 */
	public function resource_hints($urls, $relation_type)
	{
		if ('dns-prefetch' === $relation_type) {
			$urls[] = '//fonts.googleapis.com';
			$urls[] = '//fonts.gstatic.com';
		}

		return $urls;
	}

	/**
	 * Get theme option with fallback
	 */
	public function get_option($option, $default = '')
	{
		return get_theme_mod('drakkar_' . $option, $default);
	}

	/**
	 * Get theme version
	 */
	public function get_version()
	{
		return self::VERSION;
	}

	/**
	 * Get theme directory
	 */
	public function get_theme_dir()
	{
		return $this->theme_dir;
	}

	/**
	 * Get theme URI
	 */
	public function get_theme_uri()
	{
		return $this->theme_uri;
	}

	/**
	 * Get asset manager
	 */
	public function get_assets()
	{
		return $this->assets;
	}

	/**
	 * Get media manager
	 */
	public function get_media()
	{
		return $this->media;
	}

	/**
	 * Get components manager
	 */
	public function get_components()
	{
		return $this->components;
	}

	/**
	 * Get navigation manager
	 */
	public function get_navigation()
	{
		return $this->navigation;
	}
}

/**
 * Get theme instance
 */
function drakkar_theme()
{
	return Drakkar_Theme::get_instance();
}

// Initialize theme
drakkar_theme();
