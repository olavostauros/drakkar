<?php
/**
 * Theme Customizer for Media Settings
 * 
 * @package Drakkar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add media-related customizer settings
 * 
 * @param WP_Customize_Manager $wp_customize Theme Customizer object
 */
function drakkar_customize_media_settings($wp_customize) {
    
    // Add Media Settings Section
    $wp_customize->add_section('drakkar_media_settings', array(
        'title' => __('Drakkar Media Settings', 'drakkar'),
        'priority' => 35,
        'description' => __('Configure media and image settings for your theme.', 'drakkar'),
    ));
    
    // Default Featured Image
    $wp_customize->add_setting('drakkar_default_featured_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'drakkar_default_featured_image', array(
        'label' => __('Default Featured Image', 'drakkar'),
        'description' => __('Select a default image to use when posts don\'t have a featured image.', 'drakkar'),
        'section' => 'drakkar_media_settings',
        'mime_type' => 'image',
    )));
    
    // Hero Background Image
    $wp_customize->add_setting('drakkar_hero_background', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'drakkar_hero_background', array(
        'label' => __('Hero Section Background', 'drakkar'),
        'description' => __('Select a background image for the hero section.', 'drakkar'),
        'section' => 'drakkar_media_settings',
        'mime_type' => 'image',
    )));
    
    // About Section Image
    $wp_customize->add_setting('drakkar_about_image', array(
        'default' => '',
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'drakkar_about_image', array(
        'label' => __('About Section Image', 'drakkar'),
        'description' => __('Select an image for the about section.', 'drakkar'),
        'section' => 'drakkar_media_settings',
        'mime_type' => 'image',
    )));
    
    // Enable Lazy Loading
    $wp_customize->add_setting('drakkar_enable_lazy_loading', array(
        'default' => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    
    $wp_customize->add_control('drakkar_enable_lazy_loading', array(
        'type' => 'checkbox',
        'label' => __('Enable Lazy Loading', 'drakkar'),
        'description' => __('Enable lazy loading for images to improve page load speed.', 'drakkar'),
        'section' => 'drakkar_media_settings',
    ));
    
    // Image Quality
    $wp_customize->add_setting('drakkar_image_quality', array(
        'default' => 85,
        'sanitize_callback' => 'absint',
    ));
    
    $wp_customize->add_control('drakkar_image_quality', array(
        'type' => 'range',
        'label' => __('Image Quality', 'drakkar'),
        'description' => __('Set the JPEG compression quality (1-100).', 'drakkar'),
        'section' => 'drakkar_media_settings',
        'input_attrs' => array(
            'min' => 1,
            'max' => 100,
            'step' => 1,
        ),
    ));
}
add_action('customize_register', 'drakkar_customize_media_settings');

/**
 * Get customizer media setting
 * 
 * @param string $setting Setting name
 * @param mixed $default Default value
 * @return mixed Setting value
 */
function drakkar_get_media_setting($setting, $default = '') {
    return get_theme_mod('drakkar_' . $setting, $default);
}
