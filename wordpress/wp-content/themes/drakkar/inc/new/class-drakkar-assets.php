<?php

/**
 * Drakkar Asset Manager
 *
 * Handles all theme asset loading with unified enqueuing system
 *
 * @package Drakkar
 * @version 2.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Drakkar_Assets
{

    /**
     * Theme version for cache busting
     */
    private static $theme_version = '2.0.0';

    /**
     * Initialize asset management
     */
    public static function init()
    {
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_styles']);
        add_action('wp_enqueue_scripts', [self::class, 'enqueue_scripts']);
        add_action('wp_head', [self::class, 'preload_critical_resources'], 1);
    }

    /**
     * Enqueue stylesheets
     */
    public static function enqueue_styles()
    {
        // Main consolidated stylesheet
        wp_enqueue_style(
            'drakkar-main',
            self::get_asset_url('dist/main.css'),
            [],
            self::get_asset_version('dist/main.css')
        );

        // Preload Google Fonts if needed
        self::preload_google_fonts();
    }

    /**
     * Enqueue JavaScript files
     */
    public static function enqueue_scripts()
    {
        // Main unified JavaScript (all functionality consolidated)
        wp_enqueue_script(
            'drakkar-main',
            self::get_asset_url('dist/main.js'),
            [],
            self::get_asset_version('dist/main.js'),
            true // Load in footer
        );

        // Add inline script with localized data
        wp_add_inline_script(
            'drakkar-main',
            self::get_inline_script_data(),
            'before'
        );
    }

    /**
     * Get asset URL with proper template directory
     */
    private static function get_asset_url($path)
    {
        return get_template_directory_uri() . '/' . ltrim($path, '/');
    }

    /**
     * Get asset version for cache busting
     * Uses file modification time for development, static version for production
     */
    private static function get_asset_version($path)
    {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            // In development, use file modification time
            $file_path = get_template_directory() . '/' . ltrim($path, '/');
            return file_exists($file_path) ? filemtime($file_path) : self::$theme_version;
        }

        // In production, use static version
        return self::$theme_version;
    }

    /**
     * Preload critical resources for performance
     */
    public static function preload_critical_resources()
    {
        // Preload main CSS
        echo '<link rel="preload" href="' . esc_url(self::get_asset_url('dist/main.css')) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";

        // Preload main JavaScript
        echo '<link rel="preload" href="' . esc_url(self::get_asset_url('dist/main.js')) . '" as="script">' . "\n";

        // Preload logo if custom logo is set
        if (has_custom_logo()) {
            $logo_id = get_theme_mod('custom_logo');
            $logo_url = wp_get_attachment_image_src($logo_id, 'full');
            if ($logo_url) {
                echo '<link rel="preload" href="' . esc_url($logo_url[0]) . '" as="image">' . "\n";
            }
        }
    }

    /**
     * Preload Google Fonts if needed
     */
    private static function preload_google_fonts()
    {
        // If theme uses Google Fonts, add preconnect for performance
        // Currently using system fonts, but keeping for future use

        // Example for Google Fonts:
        // echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        // echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    }

    /**
     * Get inline script data for JavaScript
     */
    private static function get_inline_script_data()
    {
        $data = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('drakkar_nonce'),
            'themeUrl' => get_template_directory_uri(),
            'siteUrl' => home_url(),
            'isDebug' => defined('WP_DEBUG') && WP_DEBUG,
        ];

        return 'window.drakkarData = ' . wp_json_encode($data) . ';';
    }

    /**
     * Conditional asset loading based on page context
     *
     * Note: With unified JavaScript architecture, most functionality is
     * already included in dist/main.js. This method is kept for potential
     * future page-specific scripts that don't belong in the main bundle.
     */
    public static function conditional_enqueue($hook)
    {
        // All core functionality is now in unified dist/main.js
        // This method can be used for page-specific scripts if needed in the future

        // Example for future use:
        // if (is_page('special-page')) {
        //     wp_enqueue_script(
        //         'drakkar-special-feature',
        //         self::get_asset_url('js/special-feature.js'),
        //         ['drakkar-main'],
        //         self::get_asset_version('js/special-feature.js'),
        //         true
        //     );
        // }
    }

    /**
     * Inline critical CSS for above-the-fold content
     */
    public static function inline_critical_css()
    {
        $critical_css = self::get_critical_css();
        if ($critical_css) {
            echo '<style id="critical-css">' . $critical_css . '</style>' . "\n";
        }
    }

    /**
     * Get critical CSS for above-the-fold content
     */
    private static function get_critical_css()
    {
        // Essential above-the-fold styles
        return '
            :root {
                --color-primary: #c53e3e;
                --color-white: #ffffff;
                --color-text-primary: #333;
                --font-family-base: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
                --header-height: 80px;
                --container-max-width: 1200px;
                --container-padding: 20px;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: var(--font-family-base);
                line-height: 1.6;
                color: var(--color-text-primary);
            }

            .site-header {
                background: var(--color-white);
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
                position: sticky;
                top: 0;
                z-index: 1000;
                transition: all 0.3s ease;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .header-container {
                max-width: var(--container-max-width);
                margin: 0 auto;
                padding: 0 var(--container-padding);
                display: flex;
                align-items: center;
                justify-content: space-between;
                height: var(--header-height);
            }
        ';
    }

    /**
     * Remove WordPress default styles/scripts that are not needed
     */
    public static function cleanup_wp_head()
    {
        // Remove WordPress generator meta tag
        remove_action('wp_head', 'wp_generator');

        // Remove RSD link
        remove_action('wp_head', 'rsd_link');

        // Remove Windows Live Writer manifest link
        remove_action('wp_head', 'wlwmanifest_link');

        // Remove WordPress shortlink
        remove_action('wp_head', 'wp_shortlink_wp_head');

        // Remove recent comments styles
        add_action('widgets_init', function () {
            global $wp_widget_factory;
            remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
        });

        // Remove emoji scripts (if not needed)
        if (!is_admin()) {
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
        }
    }

    /**
     * Add resource hints for performance
     */
    public static function add_resource_hints($urls, $relation_type)
    {
        switch ($relation_type) {
            case 'dns-prefetch':
                // Add domains for DNS prefetch
                $urls[] = '//fonts.googleapis.com';
                $urls[] = '//fonts.gstatic.com';
                break;

            case 'preconnect':
                // Add origins for preconnect
                if (is_front_page()) {
                    $urls[] = get_template_directory_uri();
                }
                break;
        }

        return $urls;
    }
}

// Initialize asset management
add_action('after_setup_theme', [Drakkar_Assets::class, 'init']);

// Additional performance optimizations
add_action('init', [Drakkar_Assets::class, 'cleanup_wp_head']);
add_filter('wp_resource_hints', [Drakkar_Assets::class, 'add_resource_hints'], 10, 2);
