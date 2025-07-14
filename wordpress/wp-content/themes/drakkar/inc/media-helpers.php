<?php
/**
 * Media Helper Functions for Drakkar Theme
 * 
 * @package Drakkar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get theme asset URL
 * 
 * @param string $path Path relative to assets directory
 * @return string Full URL to asset
 */
function drakkar_get_asset_url($path) {
    return get_template_directory_uri() . '/assets/' . ltrim($path, '/');
}

/**
 * Get theme image URL
 * 
 * @param string $filename Image filename
 * @return string Full URL to image
 */
function drakkar_get_image_url($filename) {
    return drakkar_get_asset_url('images/' . $filename);
}

/**
 * Get theme icon URL
 * 
 * @param string $filename Icon filename
 * @return string Full URL to icon
 */
function drakkar_get_icon_url($filename) {
    return drakkar_get_asset_url('icons/' . $filename);
}

/**
 * Get responsive image HTML
 * 
 * @param int $attachment_id Attachment ID
 * @param string $size Image size
 * @param array $attr Additional attributes
 * @return string Image HTML
 */
function drakkar_get_responsive_image($attachment_id, $size = 'full', $attr = array()) {
    if (!$attachment_id) {
        return '';
    }
    
    // Set default attributes
    $default_attr = array(
        'loading' => 'lazy',
        'class' => 'responsive-image'
    );
    
    $attr = wp_parse_args($attr, $default_attr);
    
    return wp_get_attachment_image($attachment_id, $size, false, $attr);
}

/**
 * Get featured image with fallback
 * 
 * @param int $post_id Post ID (optional, defaults to current post)
 * @param string $size Image size
 * @param string $fallback_image Fallback image filename in theme assets
 * @return string Image HTML
 */
function drakkar_get_featured_image($post_id = null, $size = 'full', $fallback_image = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    if (has_post_thumbnail($post_id)) {
        return get_the_post_thumbnail($post_id, $size, array(
            'loading' => 'lazy',
            'class' => 'featured-image'
        ));
    } elseif ($fallback_image) {
        $fallback_url = drakkar_get_image_url($fallback_image);
        return '<img src="' . esc_url($fallback_url) . '" class="featured-image fallback" alt="' . esc_attr(get_the_title($post_id)) . '" loading="lazy" />';
    }
    
    return '';
}

/**
 * Get attachment metadata
 * 
 * @param int $attachment_id Attachment ID
 * @return array|false Attachment metadata or false
 */
function drakkar_get_attachment_meta($attachment_id) {
    if (!$attachment_id) {
        return false;
    }
    
    $attachment = get_post($attachment_id);
    if (!$attachment) {
        return false;
    }
    
    $metadata = wp_get_attachment_metadata($attachment_id);
    
    return array(
        'title' => get_the_title($attachment_id),
        'caption' => wp_get_attachment_caption($attachment_id),
        'description' => $attachment->post_content,
        'alt' => get_post_meta($attachment_id, '_wp_attachment_image_alt', true),
        'url' => wp_get_attachment_url($attachment_id),
        'metadata' => $metadata
    );
}

/**
 * Generate srcset for responsive images
 * 
 * @param int $attachment_id Attachment ID
 * @param array $sizes Array of image sizes
 * @return string Srcset attribute
 */
function drakkar_get_image_srcset($attachment_id, $sizes = array()) {
    if (!$attachment_id) {
        return '';
    }
    
    if (empty($sizes)) {
        $sizes = array('thumbnail', 'medium', 'large', 'full');
    }
    
    $srcset = array();
    
    foreach ($sizes as $size) {
        $image = wp_get_attachment_image_src($attachment_id, $size);
        if ($image) {
            $srcset[] = $image[0] . ' ' . $image[1] . 'w';
        }
    }
    
    return implode(', ', $srcset);
}

/**
 * Get media library image by filename
 * 
 * @param string $filename Image filename
 * @return int|false Attachment ID or false
 */
function drakkar_get_attachment_id_by_filename($filename) {
    global $wpdb;
    
    $attachment = $wpdb->get_col($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} WHERE post_type='attachment' AND post_name = %s",
        sanitize_title($filename)
    ));
    
    return !empty($attachment) ? $attachment[0] : false;
}

/**
 * Check if image exists in theme assets
 * 
 * @param string $filename Image filename
 * @return bool True if image exists
 */
function drakkar_theme_image_exists($filename) {
    $image_path = get_template_directory() . '/assets/images/' . $filename;
    return file_exists($image_path);
}

/**
 * Get optimized image sizes for different screen sizes
 * 
 * @return array Image sizes configuration
 */
function drakkar_get_image_sizes() {
    return array(
        'drakkar-thumbnail' => array(150, 150, true),
        'drakkar-small' => array(300, 200, true),
        'drakkar-medium' => array(600, 400, true),
        'drakkar-large' => array(1200, 800, true),
        'drakkar-hero' => array(1920, 1080, true),
    );
}
