<?php

/**
 * Drakkar Assets Manager
 *
 * Unified asset management system for styles, scripts, and optimization
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Drakkar Assets Manager Class
 */
class Drakkar_Assets_Manager
{

	/**
	 * Asset version for cache busting
	 */
	private $version;

	/**
	 * Theme URI
	 */
	private $theme_uri;

	/**
	 * Asset manifest for versioning
	 */
	private $manifest = [];

	/**
	 * Critical CSS
	 */
	private $critical_css = '';

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->version = drakkar_theme()->get_version();
		$this->theme_uri = drakkar_theme()->get_theme_uri();
		$this->load_manifest();
	}

	/**
	 * Initialize asset management
	 */
	public function init()
	{
		add_action('wp_enqueue_scripts', [$this, 'enqueue'], 10);
		add_action('wp_head', [$this, 'preload_critical'], 1);
		add_action('wp_head', [$this, 'inline_critical_css'], 2);
		add_action('admin_enqueue_scripts', [$this, 'admin_assets']);

		// Optimization hooks
		add_action('wp_head', [$this, 'cleanup_head'], 0);
		add_filter('style_loader_tag', [$this, 'optimize_css_delivery'], 10, 4);
		add_filter('script_loader_tag', [$this, 'optimize_js_delivery'], 10, 3);
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue()
	{
		// Enqueue styles
		$this->enqueue_styles();

		// Enqueue scripts
		$this->enqueue_scripts();

		// Conditional assets
		$this->conditional_assets();
	}

	/**
	 * Enqueue stylesheets
	 */
	private function enqueue_styles()
	{
		// Main theme stylesheet
		wp_enqueue_style(
			'drakkar-main',
			$this->get_asset_url('css/main.css'),
			[],
			$this->get_asset_version('css/main.css')
		);

		// Component styles (conditionally loaded)
		if (is_front_page()) {
			wp_enqueue_style(
				'drakkar-front-page',
				$this->get_asset_url('css/front-page.css'),
				['drakkar-main'],
				$this->get_asset_version('css/front-page.css')
			);
		}

		// Print styles
		wp_enqueue_style(
			'drakkar-print',
			$this->get_asset_url('css/print.css'),
			['drakkar-main'],
			$this->get_asset_version('css/print.css'),
			'print'
		);

		// Google Fonts (optimized loading)
		$this->enqueue_google_fonts();
	}

	/**
	 * Enqueue scripts
	 */
	private function enqueue_scripts()
	{
		// Main theme script
		wp_enqueue_script(
			'drakkar-main',
			$this->get_asset_url('js/main.js'),
			['jquery'],
			$this->get_asset_version('js/main.js'),
			true
		);

		// Localize script data
		wp_localize_script('drakkar-main', 'drakkarData', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('drakkar_nonce'),
			'themeUrl' => $this->theme_uri,
			'version' => $this->version,
			'isRTL' => is_rtl(),
			'locale' => get_locale()
		]);

		// Hero section scripts (conditional)
		if (is_front_page() || has_block('drakkar/hero')) {
			wp_enqueue_script(
				'drakkar-hero',
				$this->get_asset_url('js/components/hero.js'),
				['drakkar-main'],
				$this->get_asset_version('js/components/hero.js'),
				true
			);
		}

		// Navigation scripts
		wp_enqueue_script(
			'drakkar-navigation',
			$this->get_asset_url('js/components/navigation.js'),
			['drakkar-main'],
			$this->get_asset_version('js/components/navigation.js'),
			true
		);

		// Responsive images script
		if (drakkar_theme()->get_option('lazy_loading', true)) {
			wp_enqueue_script(
				'drakkar-lazy-loading',
				$this->get_asset_url('js/components/lazy-loading.js'),
				['drakkar-main'],
				$this->get_asset_version('js/components/lazy-loading.js'),
				true
			);
		}
	}

	/**
	 * Enqueue Google Fonts with optimization
	 */
	private function enqueue_google_fonts()
	{
		$fonts = $this->get_google_fonts();

		if (!empty($fonts)) {
			// Preconnect to Google Fonts
			add_action('wp_head', function () {
				echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
				echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
			}, 1);

			// Build font URL
			$font_url = 'https://fonts.googleapis.com/css2?' . http_build_query([
				'family' => implode('&family=', $fonts),
				'display' => 'swap'
			]);

			wp_enqueue_style(
				'drakkar-google-fonts',
				$font_url,
				[],
				null
			);
		}
	}

	/**
	 * Get Google Fonts configuration
	 */
	private function get_google_fonts()
	{
		$fonts = [
			'Inter:wght@300;400;500;600;700',
			'Poppins:wght@400;500;600;700'
		];

		return apply_filters('drakkar_google_fonts', $fonts);
	}

	/**
	 * Conditional asset loading
	 */
	private function conditional_assets()
	{
		// Contact form assets
		if (is_page_template('template-contact.php') || has_shortcode(get_post()->post_content ?? '', 'contact_form')) {
			wp_enqueue_script(
				'drakkar-contact-form',
				$this->get_asset_url('js/components/contact-form.js'),
				['drakkar-main'],
				$this->get_asset_version('js/components/contact-form.js'),
				true
			);

			wp_enqueue_style(
				'drakkar-contact-form',
				$this->get_asset_url('css/components/contact-form.css'),
				['drakkar-main'],
				$this->get_asset_version('css/components/contact-form.css')
			);
		}

		// Statistics animation
		if (has_block('drakkar/statistics') || is_front_page()) {
			wp_enqueue_script(
				'drakkar-statistics',
				$this->get_asset_url('js/components/statistics.js'),
				['drakkar-main'],
				$this->get_asset_version('js/components/statistics.js'),
				true
			);
		}

		// WhatsApp widget
		if (drakkar_theme()->get_option('whatsapp_widget_enable', false)) {
			wp_enqueue_script(
				'drakkar-whatsapp',
				$this->get_asset_url('js/components/whatsapp-widget.js'),
				['drakkar-main'],
				$this->get_asset_version('js/components/whatsapp-widget.js'),
				true
			);

			wp_enqueue_style(
				'drakkar-whatsapp',
				$this->get_asset_url('css/components/whatsapp-widget.css'),
				['drakkar-main'],
				$this->get_asset_version('css/components/whatsapp-widget.css')
			);
		}
	}

	/**
	 * Enqueue admin assets
	 */
	public function admin_assets($hook)
	{
		// Theme customizer assets
		if ('customize.php' === $hook) {
			wp_enqueue_style(
				'drakkar-customizer',
				$this->get_asset_url('css/admin/customizer.css'),
				[],
				$this->version
			);

			wp_enqueue_script(
				'drakkar-customizer',
				$this->get_asset_url('js/admin/customizer.js'),
				['jquery', 'customize-controls'],
				$this->version,
				true
			);
		}

		// Admin dashboard assets
		if ('index.php' === $hook || 'appearance_page_' === substr($hook, 0, 16)) {
			wp_enqueue_style(
				'drakkar-admin',
				$this->get_asset_url('css/admin/admin.css'),
				[],
				$this->version
			);
		}
	}

	/**
	 * Preload critical resources
	 */
	public function preload_critical()
	{
		// Preload critical CSS
		$critical_css_url = $this->get_asset_url('css/critical.css');
		echo '<link rel="preload" href="' . esc_url($critical_css_url) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";

		// Preload main font
		$main_font_url = $this->get_asset_url('fonts/inter-var.woff2');
		if (file_exists(str_replace($this->theme_uri, drakkar_theme()->get_theme_dir(), $main_font_url))) {
			echo '<link rel="preload" href="' . esc_url($main_font_url) . '" as="font" type="font/woff2" crossorigin>' . "\n";
		}

		// Preload hero image on front page
		if (is_front_page()) {
			$hero_image = drakkar_theme()->get_option('hero_background_image');
			if ($hero_image) {
				$hero_url = wp_get_attachment_image_url($hero_image, 'drakkar-hero');
				if ($hero_url) {
					echo '<link rel="preload" href="' . esc_url($hero_url) . '" as="image">' . "\n";
				}
			}
		}
	}

	/**
	 * Inline critical CSS
	 */
	public function inline_critical_css()
	{
		if (!empty($this->critical_css)) {
			echo '<style id="drakkar-critical-css">' . $this->critical_css . '</style>' . "\n";
		}
	}

	/**
	 * Clean up wp_head
	 */
	public function cleanup_head()
	{
		// Remove unnecessary meta tags and links
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'wlwmanifest_link');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'wp_shortlink_wp_head');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

		// Remove emoji scripts (can be re-enabled via customizer)
		if (!drakkar_theme()->get_option('enable_emojis', false)) {
			remove_action('wp_head', 'print_emoji_detection_script', 7);
			remove_action('wp_print_styles', 'print_emoji_styles');
		}
	}

	/**
	 * Optimize CSS delivery
	 */
	public function optimize_css_delivery($tag, $handle, $href, $media)
	{
		// Add defer for non-critical stylesheets
		$non_critical = ['drakkar-print', 'drakkar-contact-form'];

		if (in_array($handle, $non_critical)) {
			$tag = str_replace("rel='stylesheet'", "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"", $tag);
		}

		return $tag;
	}

	/**
	 * Optimize JavaScript delivery
	 */
	public function optimize_js_delivery($tag, $handle, $src)
	{
		// Add defer to non-critical scripts
		$defer_scripts = ['drakkar-contact-form', 'drakkar-statistics', 'drakkar-whatsapp'];

		if (in_array($handle, $defer_scripts)) {
			$tag = str_replace('<script ', '<script defer ', $tag);
		}

		return $tag;
	}

	/**
	 * Get asset URL
	 */
	private function get_asset_url($path)
	{
		return $this->theme_uri . '/assets/' . ltrim($path, '/');
	}

	/**
	 * Get asset version from manifest or file modification time
	 */
	private function get_asset_version($path)
	{
		// Check manifest first
		if (isset($this->manifest[$path])) {
			return $this->manifest[$path];
		}

		// Fallback to file modification time
		$file_path = drakkar_theme()->get_theme_dir() . '/assets/' . ltrim($path, '/');
		if (file_exists($file_path)) {
			return filemtime($file_path);
		}

		return $this->version;
	}

	/**
	 * Load asset manifest
	 */
	private function load_manifest()
	{
		$manifest_path = drakkar_theme()->get_theme_dir() . '/assets/manifest.json';

		if (file_exists($manifest_path)) {
			$manifest_content = file_get_contents($manifest_path);
			$this->manifest = json_decode($manifest_content, true) ?: [];
		}
	}

	/**
	 * Load critical CSS
	 */
	private function load_critical_css()
	{
		$critical_path = drakkar_theme()->get_theme_dir() . '/assets/css/critical.css';

		if (file_exists($critical_path)) {
			$this->critical_css = file_get_contents($critical_path);
			// Minify inline CSS
			$this->critical_css = preg_replace('/\s+/', ' ', $this->critical_css);
			$this->critical_css = trim($this->critical_css);
		}
	}

	/**
	 * Get asset manifest
	 */
	public function get_manifest()
	{
		return $this->manifest;
	}

	/**
	 * Check if asset exists
	 */
	public function asset_exists($path)
	{
		$file_path = drakkar_theme()->get_theme_dir() . '/assets/' . ltrim($path, '/');
		return file_exists($file_path);
	}
}
