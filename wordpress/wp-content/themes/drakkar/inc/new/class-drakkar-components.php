<?php
/**
 * Drakkar Components System
 *
 * Provides reusable template components for consistent output
 *
 * @package Drakkar
 * @version 2.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Drakkar_Components {

    /**
     * Generate hero section component
     *
     * @param array $args Hero configuration
     * @return string HTML output
     */
    public static function hero_section($args = []) {
        $defaults = [
            'type' => 'main',
            'background' => '',
            'title' => '',
            'subtitle' => '',
            'description' => '',
            'cta' => [],
            'video' => '',
            'overlay' => true,
            'statistics' => [],
            'badge' => '',
            'alignment' => 'center', // center, left, right
            'classes' => []
        ];

        $args = wp_parse_args($args, $defaults);

        // Escape values
        $title = wp_kses_post($args['title']);
        $subtitle = wp_kses_post($args['subtitle']);
        $description = wp_kses_post($args['description']);
        $badge = esc_html($args['badge']);
        $background_url = esc_url($args['background']);
        $video_url = esc_url($args['video']);

        // Build classes
        $hero_classes = ['hero'];
        $hero_classes[] = 'hero--' . sanitize_html_class($args['type']);

        // Add specific classes for different hero types
        if ($args['type'] === 'expertise') {
            $hero_classes[] = 'hero-expertise';
        } elseif ($args['type'] === 'main') {
            $hero_classes[] = 'hero-section';
        }

        if (!empty($args['classes'])) {
            $hero_classes = array_merge($hero_classes, (array) $args['classes']);
        }

        $content_classes = ['hero__content'];

        // Add specific content classes for expertise type
        if ($args['type'] === 'expertise') {
            $content_classes[] = 'expertise-content';
        } else {
            $content_classes[] = 'hero-content';
        }

        $content_classes[] = 'hero__content--' . sanitize_html_class($args['alignment']);

        // Start output
        ob_start();
        ?>

        <section class="<?php echo esc_attr(implode(' ', $hero_classes)); ?>"
                 <?php if ($background_url) : ?>style="background-image: url('<?php echo $background_url; ?>');"<?php endif; ?>>

            <?php if ($video_url) : ?>
                <div class="hero-video-container">
                    <video class="hero-video" autoplay muted loop playsinline>
                        <source src="<?php echo $video_url; ?>" type="video/mp4">
                    </video>
                </div>
            <?php endif; ?>

            <?php if ($args['overlay']) : ?>
                <?php if ($args['type'] === 'expertise') : ?>
                    <div class="expertise-background"></div>
                <?php else : ?>
                    <div class="hero__overlay"></div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="<?php echo esc_attr(implode(' ', $content_classes)); ?>">

                <?php if ($badge) : ?>
                    <?php if ($args['type'] === 'expertise') : ?>
                        <span class="expertise-badge"><?php echo $badge; ?></span>
                    <?php else : ?>
                        <span class="hero__badge"><?php echo $badge; ?></span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <?php if ($args['type'] === 'expertise') : ?>
                        <h1 class="expertise-title"><?php echo $title; ?></h1>
                    <?php else : ?>
                        <h1 class="hero__title"><?php echo $title; ?></h1>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <h2 class="hero__subtitle"><?php echo $subtitle; ?></h2>
                <?php endif; ?>

                <?php if ($description) : ?>
                    <p class="hero-description"><?php echo $description; ?></p>
                <?php endif; ?>

                <?php if (!empty($args['cta'])) : ?>
                    <?php echo self::cta_button($args['cta']); ?>
                <?php endif; ?>

            </div>

            <?php if (!empty($args['statistics'])) : ?>
                <?php echo self::statistics_section($args['statistics']); ?>
            <?php endif; ?>

        </section>

        <?php
        return ob_get_clean();
    }

    /**
     * Generate CTA button component
     *
     * @param array $args Button configuration
     * @return string HTML output
     */
    public static function cta_button($args = []) {
        $defaults = [
            'text' => 'Clique aqui',
            'url' => '#',
            'style' => 'primary', // primary, secondary, outline
            'size' => 'normal', // small, normal, large
            'icon' => '',
            'target' => '_self',
            'classes' => []
        ];

        $args = wp_parse_args($args, $defaults);

        // Escape values
        $text = wp_kses_post($args['text']);
        $url = esc_url($args['url']);
        $target = esc_attr($args['target']);
        $icon = esc_html($args['icon']);

        // Build classes
        $button_classes = ['btn'];
        $button_classes[] = 'btn--' . sanitize_html_class($args['style']);
        $button_classes[] = 'btn--' . sanitize_html_class($args['size']);
        if (!empty($args['classes'])) {
            $button_classes = array_merge($button_classes, (array) $args['classes']);
        }

        ob_start();
        ?>

        <a href="<?php echo $url; ?>"
           class="<?php echo esc_attr(implode(' ', $button_classes)); ?>"
           target="<?php echo $target; ?>">
            <?php if ($icon) : ?>
                <span class="btn__icon"><?php echo $icon; ?></span>
            <?php endif; ?>
            <span class="btn__text"><?php echo $text; ?></span>
        </a>

        <?php
        return ob_get_clean();
    }

    /**
     * Generate statistics section component
     *
     * @param array $statistics Array of statistics
     * @return string HTML output
     */
    public static function statistics_section($statistics = []) {
        if (empty($statistics)) {
            return '';
        }

        ob_start();
        ?>

        <div class="hero-statistics">
            <?php foreach ($statistics as $index => $stat) : ?>
                <?php
                $delay = isset($stat['delay']) ? intval($stat['delay']) : ($index * 200);
                $number = esc_html($stat['number'] ?? '0');
                $label = esc_html($stat['label'] ?? '');
                $suffix = esc_html($stat['suffix'] ?? '');
                ?>
                <div class="stat-item" data-delay="<?php echo $delay; ?>">
                    <div class="stat-number" data-target="<?php echo $number; ?>">
                        <?php echo $number; ?><?php echo $suffix; ?>
                    </div>
                    <div class="stat-label"><?php echo $label; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Generate responsive image component
     *
     * @param array $args Image configuration
     * @return string HTML output
     */
    public static function responsive_image($args = []) {
        $defaults = [
            'src' => '',
            'alt' => '',
            'sizes' => [],
            'lazy' => true,
            'classes' => [],
            'width' => '',
            'height' => ''
        ];

        $args = wp_parse_args($args, $defaults);

        // Escape values
        $src = esc_url($args['src']);
        $alt = esc_attr($args['alt']);
        $width = esc_attr($args['width']);
        $height = esc_attr($args['height']);

        // Build classes
        $img_classes = ['responsive-image'];
        if ($args['lazy']) {
            $img_classes[] = 'lazy';
        }
        if (!empty($args['classes'])) {
            $img_classes = array_merge($img_classes, (array) $args['classes']);
        }

        ob_start();
        ?>

        <img <?php echo $args['lazy'] ? 'data-src' : 'src'; ?>="<?php echo $src; ?>"
             alt="<?php echo $alt; ?>"
             class="<?php echo esc_attr(implode(' ', $img_classes)); ?>"
             <?php if ($width) : ?>width="<?php echo $width; ?>"<?php endif; ?>
             <?php if ($height) : ?>height="<?php echo $height; ?>"<?php endif; ?>
             <?php if ($args['lazy']) : ?>loading="lazy"<?php endif; ?>>

        <?php
        return ob_get_clean();
    }

    /**
     * Generate WhatsApp widget component
     *
     * @param array $args Widget configuration
     * @return string HTML output
     */
    public static function whatsapp_widget($args = []) {
        $defaults = [
            'phone' => '',
            'message' => 'Olá! Gostaria de saber mais sobre os serviços da Drakkar.',
            'tooltip' => 'Fale conosco no WhatsApp',
            'position' => 'bottom-right' // bottom-right, bottom-left
        ];

        $args = wp_parse_args($args, $defaults);

        if (empty($args['phone'])) {
            return '';
        }

        // Clean phone number
        $phone = preg_replace('/[^0-9]/', '', $args['phone']);
        $whatsapp_url = 'https://wa.me/' . $phone . '?text=' . urlencode($args['message']);

        // Escape values
        $tooltip = esc_html($args['tooltip']);
        $url = esc_url($whatsapp_url);

        // Position classes
        $widget_classes = ['whatsapp-widget'];
        $widget_classes[] = 'whatsapp-widget--' . sanitize_html_class($args['position']);

        ob_start();
        ?>

        <div class="<?php echo esc_attr(implode(' ', $widget_classes)); ?>">
            <a href="<?php echo $url; ?>"
               class="whatsapp-button"
               target="_blank"
               rel="noopener noreferrer"
               aria-label="<?php echo $tooltip; ?>">
                <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                <span class="whatsapp-tooltip"><?php echo $tooltip; ?></span>
            </a>
        </div>

        <?php
        return ob_get_clean();
    }

    /**
     * Check if a component is being used on current page
     *
     * @param string $component Component name
     * @return boolean
     */
    public static function has_component($component) {
        // This can be used for conditional asset loading
        global $wp_query;

        switch ($component) {
            case 'hero-video':
                return is_front_page();

            case 'statistics':
                return is_front_page() || is_page('sobre');

            case 'whatsapp':
                return !is_admin();

            case 'contact-form':
                return is_page('contact') || is_page('contato');

            default:
                return false;
        }
    }

    /**
     * Get theme image URL with fallback
     *
     * @param string $filename Image filename
     * @param string $fallback Fallback image
     * @return string Image URL
     */
    public static function get_image_url($filename, $fallback = '') {
        $image_path = get_template_directory() . '/assets/images/' . $filename;

        if (file_exists($image_path)) {
            return get_template_directory_uri() . '/assets/images/' . $filename;
        }

        if ($fallback) {
            $fallback_path = get_template_directory() . '/assets/images/' . $fallback;
            if (file_exists($fallback_path)) {
                return get_template_directory_uri() . '/assets/images/' . $fallback;
            }
        }

        // Return placeholder if no image found
        return 'data:image/svg+xml;base64,' . base64_encode(
            '<svg width="800" height="600" xmlns="http://www.w3.org/2000/svg"><rect width="100%" height="100%" fill="#f0f0f0"/><text x="50%" y="50%" text-anchor="middle" fill="#999">Image not found</text></svg>'
        );
    }
}

/**
 * Helper function to check if component exists
 */
function has_drakkar_component($component) {
    return Drakkar_Components::has_component($component);
}
