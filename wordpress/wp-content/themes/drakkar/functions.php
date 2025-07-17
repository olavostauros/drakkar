<?php

/**
 * Drakkar Theme Functions - Unified Architecture v3.0
 *
 * @package Drakkar
 * @version 3.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
	exit;
}

// Load unified theme system
require_once get_template_directory() . '/inc/class-drakkar-theme.php';

/**
 * Backward compatibility functions
 *
 * These functions maintain compatibility with existing template files
 * while redirecting to the new unified system
 */

// Theme setup (maintained for backward compatibility)
function drakkar_theme_setup()
{
	// Handled by unified theme system
}

// Scripts enqueue (maintained for backward compatibility)
function drakkar_scripts()
{
	// Handled by unified asset system
}

// Legacy helper functions (redirect to new system)
function drakkar_get_logo()
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_logo() : false;
}

function drakkar_get_image_url($filename)
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_image_url($filename) : '';
}

function drakkar_get_asset_url($path)
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_asset_url($path) : '';
}

function drakkar_get_icon_url($filename)
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_icon_url($filename) : '';
}

function drakkar_get_responsive_image($attachment_id, $size = 'full', $attr = [])
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_responsive_image($attachment_id, $size, $attr) : '';
}

function drakkar_get_featured_image($post_id = null, $size = 'full', $fallback_image = null)
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->get_featured_image($post_id, $size, $fallback_image) : '';
}

function drakkar_theme_image_exists($filename)
{
	$media = drakkar_theme()->get_media();
	return $media ? $media->theme_image_exists($filename) : false;
}

function drakkar_get_media_setting($setting, $default = '')
{
	return drakkar_theme()->get_option($setting, $default);
}

// Component helper functions
function drakkar_hero_section($args = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->hero_section($args) : '';
}

function drakkar_cta_button($args = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->cta_button($args) : '';
}

function drakkar_statistics_section($statistics = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->statistics_section($statistics) : '';
}

function drakkar_whatsapp_widget($args = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->whatsapp_widget($args) : '';
}

function has_drakkar_component($component)
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->has_component($component) : false;
}

// Navigation helper functions
function drakkar_primary_nav($args = [])
{
	$navigation = drakkar_theme()->get_navigation();
	return $navigation ? $navigation->display_primary_nav($args) : '';
}

function drakkar_footer_nav($args = [])
{
	$navigation = drakkar_theme()->get_navigation();
	return $navigation ? $navigation->display_footer_nav($args) : '';
}

function drakkar_social_nav($args = [])
{
	$navigation = drakkar_theme()->get_navigation();
	return $navigation ? $navigation->display_social_nav($args) : '';
}

function drakkar_breadcrumbs($args = [])
{
	$navigation = drakkar_theme()->get_navigation();
	if ($navigation) {
		echo $navigation->display_breadcrumbs($args);
	}
}

/**
 * Template helper functions
 */

// Get theme option
function drakkar_get_option($option, $default = '')
{
	return drakkar_theme()->get_option($option, $default);
}

// Check if we're on front page and display hero
function drakkar_display_hero()
{
	if (is_front_page()) {
		$components = drakkar_theme()->get_components();
		if ($components) {
			echo $components->hero_section([
				'type' => 'main',
				'background' => drakkar_get_option('hero_background_image'),
				'title' => get_bloginfo('name'),
				'subtitle' => get_bloginfo('description'),
				'alignment' => 'center'
			]);
		}
	}
}

// Display contact form
function drakkar_contact_form($args = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->contact_form($args) : '';
}

// Display content card
function drakkar_content_card($args = [])
{
	$components = drakkar_theme()->get_components();
	return $components ? $components->content_card($args) : '';
}

/**
 * AJAX handlers for components
 */
add_action('wp_ajax_drakkar_contact_form', 'drakkar_handle_contact_form');
add_action('wp_ajax_nopriv_drakkar_contact_form', 'drakkar_handle_contact_form');

function drakkar_handle_contact_form()
{
	// Verify nonce
	if (!wp_verify_nonce($_POST['contact_nonce'] ?? '', 'drakkar_contact_form')) {
		wp_die(__('Security check failed', 'drakkar'));
	}

	// Sanitize form data
	$name = sanitize_text_field($_POST['name'] ?? '');
	$email = sanitize_email($_POST['email'] ?? '');
	$subject = sanitize_text_field($_POST['subject'] ?? '');
	$message = sanitize_textarea_field($_POST['message'] ?? '');

	// Validate required fields
	if (empty($name) || empty($email) || empty($message)) {
		wp_send_json_error(__('Please fill out all required fields.', 'drakkar'));
	}

	if (!is_email($email)) {
		wp_send_json_error(__('Please enter a valid email address.', 'drakkar'));
	}

	// Send email
	$to = drakkar_get_option('contact_email', get_option('admin_email'));
	$email_subject = $subject ?: sprintf(__('Contact form submission from %s', 'drakkar'), $name);

	$email_message = sprintf(
		__("Name: %s\nEmail: %s\nSubject: %s\n\nMessage:\n%s", 'drakkar'),
		$name,
		$email,
		$subject,
		$message
	);

	$headers = ['Content-Type: text/plain; charset=UTF-8', 'From: ' . $name . ' <' . $email . '>'];

	if (wp_mail($to, $email_subject, $email_message, $headers)) {
		wp_send_json_success(__('Thank you for your message!', 'drakkar'));
	} else {
		wp_send_json_error(__('Sorry, there was an error sending your message. Please try again.', 'drakkar'));
	}
}
