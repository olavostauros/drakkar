<?php
/**
 * Main Hero Section Component - REFACTORED v2.0
 *
 * Primary hero section for Drakkar precision agriculture website homepage
 * Features video background, responsive design, and WhatsApp widget
 *
 * Now uses the unified component system and consolidated CSS
 *
 * @package Drakkar
 * @version 2.0
 */

// Hero configuration for the component system
$hero_config = [
    'type' => 'main',
    'video' => drakkar_get_asset_url('videos/hero-video.mp4'),
    'title' => 'Chegou a nova era da Agricultura de Precisão',
    'subtitle' => 'A tecnologia que coloca o controle da fertilidade do solo na palma da sua mão',
    'cta' => [
        'text' => 'Conheça a plataforma',
        'url' => '#plataforma',
        'style' => 'primary',
        'classes' => ['hero-cta-button', 'animate-fadeInUp', 'delay-800']
    ],
    'alignment' => 'center',
    'overlay' => true,
    'classes' => ['hero-section', 'animate-fadeInUp']
];

// Output the main hero using the unified component system
?>
<section id="hero" class="hero-section">
    <!-- Video Background -->
    <div class="hero-video-container">
        <video class="hero-video" autoplay muted loop playsinline preload="metadata">
            <source src="<?php echo esc_url(drakkar_get_asset_url('videos/hero-video.mp4')); ?>" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
    </div>

    <!-- Hero Content -->
    <div class="hero-content">
        <h1 class="hero-headline animate-fadeInUp">Chegou a nova era da Agricultura de Precisão</h1>
        <p class="hero-subheadline animate-fadeInUp delay-500">A tecnologia que coloca o controle da fertilidade do solo na palma da sua mão</p>
        <a href="#plataforma" class="hero-cta-button animate-fadeInUp delay-800">Conheça a plataforma</a>
    </div>

    <!-- WhatsApp Widget using component system -->
    <?php
    echo Drakkar_Components::whatsapp_widget([
        'phone' => '5511999999999',
        'message' => 'Olá, gostaria de conhecer mais sobre a Drakkar!',
        'tooltip' => 'Seja bem-vindo a Drakkar! Como podemos ajudá-lo?',
        'position' => 'bottom-right'
    ]);
    ?>
</section>

<?php
// Note: Asset enqueuing is now handled by Drakkar_Assets class
// No need for manual wp_enqueue_* calls here
?>
