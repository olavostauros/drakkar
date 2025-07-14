<?php

/**
 * Drakkar Theme Functions
 * 
 * @package Drakkar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// Include additional theme files
require_once get_template_directory() . '/inc/media-helpers.php';
require_once get_template_directory() . '/inc/customizer-media.php';

/**
 * Theme Setup
 */
function drakkar_theme_setup()
{
	// Add theme support
	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
		'height'         => 100,
		'width'          => 300,
		'flex-height'    => true,
		'flex-width'     => true,
		'header-text'    => array('site-title', 'site-description'),
		'unlink-homepage-logo' => false,
	));
	add_theme_support('menus');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'navigation-widgets',
	));
	add_theme_support('responsive-embeds');
	add_theme_support('wp-block-styles');

	// Add custom image sizes
	add_image_size('drakkar-thumbnail', 150, 150, true);
	add_image_size('drakkar-small', 300, 200, true);
	add_image_size('drakkar-medium', 600, 400, true);
	add_image_size('drakkar-large', 1200, 800, true);
	add_image_size('drakkar-hero', 1920, 1080, true);

	// Enable support for featured images
	set_post_thumbnail_size(1200, 800, true);

	// Register navigation menus
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'drakkar'),
	));
}
add_action('after_setup_theme', 'drakkar_theme_setup');

/**
 * Enqueue scripts and styles
 */
function drakkar_scripts()
{
	// Enqueue theme stylesheet
	wp_enqueue_style('drakkar-style', get_stylesheet_uri(), array(), '1.0.0');

	// Enqueue additional CSS files
	wp_enqueue_style('drakkar-hero-main-css', get_template_directory_uri() . '/css/hero-zero.css', array('drakkar-style'), '1.0.0');

	// Enqueue theme JavaScript
	wp_enqueue_script('drakkar-script', get_template_directory_uri() . '/js/main.js', array(), '1.0.0', true);
	wp_enqueue_script('drakkar-hero-script', get_template_directory_uri() . '/js/hero-main.js', array('drakkar-script'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'drakkar_scripts');

/**
 * Configure image quality
 */
function drakkar_image_quality($quality, $mime_type) {
	$custom_quality = drakkar_get_media_setting('image_quality', 85);
	return $custom_quality;
}
add_filter('wp_editor_set_quality', 'drakkar_image_quality', 10, 2);
add_filter('jpeg_quality', 'drakkar_image_quality', 10, 2);

/**
 * Add custom image sizes to media library
 */
function drakkar_custom_image_sizes($sizes) {
	return array_merge($sizes, array(
		'drakkar-thumbnail' => __('Drakkar Thumbnail', 'drakkar'),
		'drakkar-small' => __('Drakkar Small', 'drakkar'),
		'drakkar-medium' => __('Drakkar Medium', 'drakkar'),
		'drakkar-large' => __('Drakkar Large', 'drakkar'),
		'drakkar-hero' => __('Drakkar Hero', 'drakkar'),
	));
}
add_filter('image_size_names_choose', 'drakkar_custom_image_sizes');

/**
 * Get custom logo or fallback
 */
function drakkar_get_logo()
{
	if (has_custom_logo()) {
		$custom_logo_id = get_theme_mod('custom_logo');
		$logo = wp_get_attachment_image_src($custom_logo_id, 'full');

		if ($logo) {
			return '<img src="' . esc_url($logo[0]) . '" alt="' . esc_attr(get_bloginfo('name')) . ' - Agricultura de Precisão" class="custom-logo" />';
		}
	} else {
		// Try theme assets first
		if (drakkar_theme_image_exists('logo-drakkar-full.svg')) {
			return '<img src="' . esc_url(drakkar_get_image_url('logo-drakkar-full.svg')) . '" class="custom-logo" alt="' . esc_attr(get_bloginfo('name')) . ' - Agricultura de Precisão" />';
		} elseif (drakkar_theme_image_exists('logo-drakkar-full.png')) {
			return '<img src="' . esc_url(drakkar_get_image_url('logo-drakkar-full.png')) . '" class="custom-logo" alt="' . esc_attr(get_bloginfo('name')) . ' - Agricultura de Precisão" />';
		}
		
		// Fallback to wp-content/logos directory (legacy)
		$logo_svg = home_url('/wp-content/logos/logo-drakkar-full.svg');
		$logo_png = home_url('/wp-content/logos/logo-drakkar-full.png');

		if (file_exists(ABSPATH . 'wp-content/logos/logo-drakkar-full.svg')) {
			return '<img src="' . esc_url($logo_svg) . '" class="custom-logo" alt="' . esc_attr(get_bloginfo('name')) . ' - Agricultura de Precisão" />';
		} elseif (file_exists(ABSPATH . 'wp-content/logos/logo-drakkar-full.png')) {
			return '<img src="' . esc_url($logo_png) . '" class="custom-logo" alt="' . esc_attr(get_bloginfo('name')) . ' - Agricultura de Precisão" />';
		}
	}
	return false;
}

/**
 * Custom Walker for Navigation Menu
 */
class Drakkar_Walker_Nav_Menu extends Walker_Nav_Menu
{

	function start_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

	function end_lvl(&$output, $depth = 0, $args = null)
	{
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
	{
		$indent = ($depth) ? str_repeat("\t", $depth) : '';

		$classes = empty($item->classes) ? array() : (array) $item->classes;
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

	function end_el(&$output, $item, $depth = 0, $args = null)
	{
		$output .= "</li>\n";
	}
}

/**
 * Customize the excerpt length
 */
function drakkar_excerpt_length($length)
{
	return 20;
}
add_filter('excerpt_length', 'drakkar_excerpt_length');

/**
 * Add viewport meta tag for responsive design
 */
function drakkar_viewport_meta()
{
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
}
add_action('wp_head', 'drakkar_viewport_meta');

/**
 * Fallback menu when no menu is assigned
 */
function drakkar_fallback_menu()
{
	echo '<ul id="primary-menu" class="menu">';
	echo '<li><a href="#lavoura-online">Lavoura Online</a></li>';
	echo '<li><a href="#agricultura-precisao">Agricultura de Precisão</a></li>';
	echo '<li><a href="#historias-sucesso">Histórias de Sucesso</a></li>';
	echo '<li><a href="#a-drakkar">A Drakkar</a></li>';
	echo '<li><a href="#newsletter">Newsletter</a></li>';
	echo '</ul>';
}
