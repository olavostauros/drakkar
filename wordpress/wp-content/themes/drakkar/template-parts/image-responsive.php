<?php
/**
 * Template part for displaying responsive images
 * 
 * @package Drakkar
 * @param array $args {
 *     Arguments for the image display
 *     @type int    $attachment_id  Image attachment ID
 *     @type string $size          Image size (default: 'full')
 *     @type string $class         Additional CSS classes
 *     @type string $alt           Alt text (optional)
 *     @type string $fallback      Fallback image filename in theme assets
 *     @type bool   $lazy_loading  Enable lazy loading (default: true)
 *     @type array  $srcset_sizes  Custom sizes for srcset
 * }
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Set default arguments
$args = wp_parse_args($args, array(
    'attachment_id' => 0,
    'size' => 'full',
    'class' => '',
    'alt' => '',
    'fallback' => '',
    'lazy_loading' => drakkar_get_media_setting('enable_lazy_loading', true),
    'srcset_sizes' => array(),
));

$attachment_id = absint($args['attachment_id']);
$size = sanitize_text_field($args['size']);
$class = sanitize_html_class($args['class']);
$alt = sanitize_text_field($args['alt']);
$fallback = sanitize_file_name($args['fallback']);
$lazy_loading = (bool) $args['lazy_loading'];
$srcset_sizes = (array) $args['srcset_sizes'];

// Build CSS classes
$css_classes = array('drakkar-image', 'responsive-image');
if ($class) {
    $css_classes[] = $class;
}

// Try to get the image
if ($attachment_id && wp_attachment_is_image($attachment_id)) {
    // Get image attributes
    $image_src = wp_get_attachment_image_src($attachment_id, $size);
    $image_alt = $alt ?: get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    $image_title = get_the_title($attachment_id);
    
    if ($image_src) {
        // Generate srcset if custom sizes provided
        $srcset = '';
        if (!empty($srcset_sizes)) {
            $srcset = drakkar_get_image_srcset($attachment_id, $srcset_sizes);
        } else {
            $srcset = wp_get_attachment_image_srcset($attachment_id, $size);
        }
        
        // Build image attributes
        $image_attrs = array(
            'src' => esc_url($image_src[0]),
            'alt' => esc_attr($image_alt),
            'class' => esc_attr(implode(' ', $css_classes)),
            'width' => absint($image_src[1]),
            'height' => absint($image_src[2]),
        );
        
        if ($image_title) {
            $image_attrs['title'] = esc_attr($image_title);
        }
        
        if ($srcset) {
            $image_attrs['srcset'] = esc_attr($srcset);
            $image_attrs['sizes'] = '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw';
        }
        
        if ($lazy_loading) {
            $image_attrs['loading'] = 'lazy';
        }
        
        // Output the image
        echo '<img';
        foreach ($image_attrs as $attr => $value) {
            echo ' ' . $attr . '="' . $value . '"';
        }
        echo ' />';
        
    }
} elseif ($fallback && drakkar_theme_image_exists($fallback)) {
    // Use fallback image from theme assets
    $fallback_url = drakkar_get_image_url($fallback);
    $fallback_alt = $alt ?: get_bloginfo('name') . ' - Default Image';
    
    $image_attrs = array(
        'src' => esc_url($fallback_url),
        'alt' => esc_attr($fallback_alt),
        'class' => esc_attr(implode(' ', array_merge($css_classes, array('fallback-image')))),
    );
    
    if ($lazy_loading) {
        $image_attrs['loading'] = 'lazy';
    }
    
    echo '<img';
    foreach ($image_attrs as $attr => $value) {
        echo ' ' . $attr . '="' . $value . '"';
    }
    echo ' />';
    
} else {
    // No image available
    echo '<div class="' . esc_attr(implode(' ', array_merge($css_classes, array('no-image')))) . '">';
    echo '<span class="no-image-text">' . esc_html__('No image available', 'drakkar') . '</span>';
    echo '</div>';
}
