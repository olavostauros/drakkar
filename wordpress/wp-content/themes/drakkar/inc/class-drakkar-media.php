<?php

/**
 * Drakkar Media Manager
 *
 * Unified media handling system for images, responsive images, and optimization
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

/**
 * Drakkar Media Manager Class
 */
class Drakkar_Media_Manager
{

	/**
	 * Image quality setting
	 */
	private $image_quality = 85;

	/**
	 * Supported image formats
	 */
	private $supported_formats = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->image_quality = drakkar_theme()->get_option('image_quality', 85);
	}

	/**
	 * Initialize media management
	 */
	public function init()
	{
		// Image quality filters
		add_filter('wp_editor_set_quality', [$this, 'set_image_quality']);
		add_filter('jpeg_quality', [$this, 'set_image_quality']);

		// Image size filters
		add_filter('image_size_names_choose', [$this, 'add_custom_image_sizes']);

		// Responsive images
		add_filter('wp_get_attachment_image_attributes', [$this, 'add_responsive_attributes'], 10, 3);

		// WebP support
		add_filter('wp_generate_attachment_metadata', [$this, 'generate_webp_versions']);

		// Lazy loading (if not native)
		if (!drakkar_theme()->get_option('use_native_lazy_loading', true)) {
			add_filter('wp_get_attachment_image_attributes', [$this, 'add_lazy_loading_attributes'], 10, 3);
		}

		// SVG support
		if (drakkar_theme()->get_option('enable_svg_uploads', false)) {
			add_filter('upload_mimes', [$this, 'add_svg_mime_type']);
			add_filter('wp_check_filetype_and_ext', [$this, 'fix_svg_mime_type'], 10, 5);
		}
	}

	/**
	 * Set image quality
	 */
	public function set_image_quality($quality)
	{
		return $this->image_quality;
	}

	/**
	 * Add custom image sizes to media library
	 */
	public function add_custom_image_sizes($sizes)
	{
		$custom_sizes = [
			'drakkar-thumbnail' => __('Drakkar Thumbnail', 'drakkar'),
			'drakkar-small'     => __('Drakkar Small', 'drakkar'),
			'drakkar-medium'    => __('Drakkar Medium', 'drakkar'),
			'drakkar-large'     => __('Drakkar Large', 'drakkar'),
			'drakkar-hero'      => __('Drakkar Hero', 'drakkar'),
			'drakkar-square'    => __('Drakkar Square', 'drakkar'),
		];

		return array_merge($sizes, $custom_sizes);
	}

	/**
	 * Add responsive image attributes
	 */
	public function add_responsive_attributes($attr, $attachment, $size)
	{
		// Add responsive class
		$attr['class'] = isset($attr['class']) ? $attr['class'] . ' responsive-image' : 'responsive-image';

		// Add loading attribute if not already set
		if (!isset($attr['loading'])) {
			$attr['loading'] = 'lazy';
		}

		// Add decoding attribute for better performance
		$attr['decoding'] = 'async';

		return $attr;
	}

	/**
	 * Add lazy loading attributes
	 */
	public function add_lazy_loading_attributes($attr, $attachment, $size)
	{
		if (!isset($attr['loading'])) {
			$attr['loading'] = 'lazy';
			$attr['data-src'] = $attr['src'];
			$attr['src'] = $this->get_placeholder_image();
			$attr['class'] = isset($attr['class']) ? $attr['class'] . ' lazy-load' : 'lazy-load';
		}

		return $attr;
	}

	/**
	 * Generate WebP versions of images
	 */
	public function generate_webp_versions($metadata)
	{
		if (!function_exists('imagewebp')) {
			return $metadata;
		}

		$upload_dir = wp_upload_dir();
		$file_path = $upload_dir['basedir'] . '/' . $metadata['file'];

		if (file_exists($file_path) && in_array(strtolower(pathinfo($file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png'])) {
			$this->create_webp_version($file_path);

			// Generate WebP for all sizes
			if (isset($metadata['sizes']) && is_array($metadata['sizes'])) {
				foreach ($metadata['sizes'] as $size => $data) {
					$size_path = $upload_dir['basedir'] . '/' . dirname($metadata['file']) . '/' . $data['file'];
					if (file_exists($size_path)) {
						$this->create_webp_version($size_path);
					}
				}
			}
		}

		return $metadata;
	}

	/**
	 * Create WebP version of image
	 */
	private function create_webp_version($file_path)
	{
		$webp_path = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $file_path);

		if (file_exists($webp_path)) {
			return true; // Already exists
		}

		$image_info = getimagesize($file_path);
		if (!$image_info) {
			return false;
		}

		$mime_type = $image_info['mime'];
		$image_resource = null;

		switch ($mime_type) {
			case 'image/jpeg':
				$image_resource = imagecreatefromjpeg($file_path);
				break;
			case 'image/png':
				$image_resource = imagecreatefrompng($file_path);
				break;
		}

		if ($image_resource) {
			$quality = $this->image_quality;
			$success = imagewebp($image_resource, $webp_path, $quality);
			imagedestroy($image_resource);
			return $success;
		}

		return false;
	}

	/**
	 * Add SVG MIME type
	 */
	public function add_svg_mime_type($mimes)
	{
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/**
	 * Fix SVG MIME type detection
	 */
	public function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime)
	{
		if ($real_mime && $real_mime === 'image/svg+xml') {
			$data['type'] = 'image/svg+xml';
			$data['ext'] = 'svg';
		}
		return $data;
	}

	/**
	 * Get theme asset URL
	 */
	public function get_asset_url($path)
	{
		return drakkar_theme()->get_theme_uri() . '/assets/' . ltrim($path, '/');
	}

	/**
	 * Get theme image URL
	 */
	public function get_image_url($filename)
	{
		return $this->get_asset_url('images/' . $filename);
	}

	/**
	 * Get theme icon URL
	 */
	public function get_icon_url($filename)
	{
		return $this->get_asset_url('icons/' . $filename);
	}

	/**
	 * Check if theme image exists
	 */
	public function theme_image_exists($filename)
	{
		$image_path = drakkar_theme()->get_theme_dir() . '/assets/images/' . $filename;
		return file_exists($image_path);
	}

	/**
	 * Get responsive image HTML
	 */
	public function get_responsive_image($attachment_id, $size = 'full', $attr = [])
	{
		if (!$attachment_id) {
			return '';
		}

		$default_attr = [
			'loading' => 'lazy',
			'class' => 'responsive-image',
			'decoding' => 'async'
		];

		$attr = wp_parse_args($attr, $default_attr);

		// Add srcset and sizes for better responsive behavior
		if (!isset($attr['srcset']) && !isset($attr['sizes'])) {
			$srcset = wp_get_attachment_image_srcset($attachment_id, $size);
			$sizes = wp_get_attachment_image_sizes($attachment_id, $size);

			if ($srcset) {
				$attr['srcset'] = $srcset;
			}
			if ($sizes) {
				$attr['sizes'] = $sizes;
			}
		}

		return wp_get_attachment_image($attachment_id, $size, false, $attr);
	}

	/**
	 * Get featured image with fallback
	 */
	public function get_featured_image($post_id = null, $size = 'full', $fallback_image = null)
	{
		if (!$post_id) {
			$post_id = get_the_ID();
		}

		if (has_post_thumbnail($post_id)) {
			$attr = [
				'loading' => 'lazy',
				'class' => 'featured-image',
				'decoding' => 'async'
			];

			return get_the_post_thumbnail($post_id, $size, $attr);
		} elseif ($fallback_image) {
			$fallback_url = $this->get_image_url($fallback_image);
			$alt_text = esc_attr(get_the_title($post_id));

			return sprintf(
				'<img src="%s" class="featured-image fallback" alt="%s" loading="lazy" decoding="async" />',
				esc_url($fallback_url),
				$alt_text
			);
		}

		return '';
	}

	/**
	 * Get optimized image with WebP support
	 */
	public function get_optimized_image($attachment_id, $size = 'full', $attr = [])
	{
		if (!$attachment_id) {
			return '';
		}

		$image_url = wp_get_attachment_image_url($attachment_id, $size);
		$webp_url = $this->get_webp_url($image_url);

		if ($webp_url && $this->browser_supports_webp()) {
			$attr['src'] = $webp_url;
		}

		return $this->get_responsive_image($attachment_id, $size, $attr);
	}

	/**
	 * Get WebP URL from regular image URL
	 */
	private function get_webp_url($image_url)
	{
		$webp_url = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $image_url);

		// Check if WebP version exists
		$webp_path = str_replace(wp_upload_dir()['baseurl'], wp_upload_dir()['basedir'], $webp_url);

		return file_exists($webp_path) ? $webp_url : false;
	}

	/**
	 * Check if browser supports WebP
	 */
	private function browser_supports_webp()
	{
		return isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
	}

	/**
	 * Get attachment metadata
	 */
	public function get_attachment_meta($attachment_id)
	{
		if (!$attachment_id) {
			return false;
		}

		$attachment = get_post($attachment_id);
		if (!$attachment) {
			return false;
		}

		$metadata = wp_get_attachment_metadata($attachment_id);

		return [
			'id' => $attachment_id,
			'title' => get_the_title($attachment_id),
			'caption' => wp_get_attachment_caption($attachment_id),
			'description' => $attachment->post_content,
			'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
			'url' => wp_get_attachment_url($attachment_id),
			'mime_type' => $attachment->post_mime_type,
			'metadata' => $metadata
		];
	}

	/**
	 * Generate custom srcset
	 */
	public function get_image_srcset($attachment_id, $sizes = [])
	{
		if (!$attachment_id) {
			return '';
		}

		if (empty($sizes)) {
			$sizes = ['thumbnail', 'medium', 'large', 'full'];
		}

		$srcset = [];

		foreach ($sizes as $size) {
			$image = wp_get_attachment_image_src($attachment_id, $size);
			if ($image && isset($image[1])) {
				$srcset[] = $image[0] . ' ' . $image[1] . 'w';
			}
		}

		return implode(', ', $srcset);
	}

	/**
	 * Get attachment ID by filename
	 */
	public function get_attachment_id_by_filename($filename)
	{
		global $wpdb;

		$attachment = $wpdb->get_col($wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_name = %s",
			sanitize_title(pathinfo($filename, PATHINFO_FILENAME))
		));

		return !empty($attachment) ? $attachment[0] : false;
	}

	/**
	 * Get placeholder image
	 */
	public function get_placeholder_image($width = 300, $height = 200)
	{
		$placeholder_url = $this->get_image_url('placeholder.svg');

		// Fallback to data URI if placeholder doesn't exist
		if (!$this->theme_image_exists('placeholder.svg')) {
			$placeholder_url = 'data:image/svg+xml;charset=UTF-8,' . urlencode(
				'<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">' .
					'<rect width="100%" height="100%" fill="#f0f0f0"/>' .
					'<text x="50%" y="50%" font-family="Arial,sans-serif" font-size="14" fill="#999" text-anchor="middle" dy=".3em">Loading...</text>' .
					'</svg>'
			);
		}

		return $placeholder_url;
	}

	/**
	 * Get optimized image sizes configuration
	 */
	public function get_image_sizes()
	{
		return [
			'drakkar-thumbnail' => [150, 150, true],
			'drakkar-small'     => [300, 200, true],
			'drakkar-medium'    => [600, 400, true],
			'drakkar-large'     => [1200, 800, true],
			'drakkar-hero'      => [1920, 1080, true],
			'drakkar-square'    => [500, 500, true],
		];
	}

	/**
	 * Get theme logo with fallbacks
	 */
	public function get_logo()
	{
		$alt_text = esc_attr(get_bloginfo('name')) . ' - ' . esc_attr(get_bloginfo('description'));
		$logo_class = 'custom-logo';

		// Check for custom logo first
		if (has_custom_logo()) {
			$custom_logo_id = get_theme_mod('custom_logo');
			$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

			if ($logo) {
				return sprintf(
					'<img src="%s" alt="%s" class="%s" />',
					esc_url($logo[0]),
					$alt_text,
					$logo_class
				);
			}
		}

		// Try theme assets
		$logo_files = ['logo-drakkar-full.svg', 'logo-drakkar-full.png', 'logo.svg', 'logo.png'];

		foreach ($logo_files as $filename) {
			if ($this->theme_image_exists($filename)) {
				return sprintf(
					'<img src="%s" class="%s" alt="%s" />',
					esc_url($this->get_image_url($filename)),
					$logo_class,
					$alt_text
				);
			}
		}

		return false;
	}
}
