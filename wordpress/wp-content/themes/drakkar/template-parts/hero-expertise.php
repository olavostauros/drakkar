<?php
/**
 * Hero Expertise Component - REFACTORED v2.0
 *
 * Hero section showcasing Drakkar's expertise and experience since 2006
 * Features company credentials, track record, and call-to-action
 *
 * Now uses the unified component system and consolidated CSS
 *
 * @package Drakkar
 * @version 2.0
 */

// Get the background image URL using theme convention
// Check if theme image exists first, then get URL
if (drakkar_theme_image_exists('backgrounds/hero-expertise.png')) {
    $expertise_bg = drakkar_get_image_url('backgrounds/hero-expertise.png');
} else {
    // Fallback to a default background if the specific image doesn't exist
    $expertise_bg = drakkar_get_image_url('backgrounds/default-hero.png');
}

// Hero configuration for the component system
$hero_config = [
    'type' => 'expertise',
    'background' => $expertise_bg,
    'badge' => 'Agricultura de Precisão',
    'title' => 'Há 19 anos transformamos<br><span class="text-accent">solo em estratégia</span>',
    'description' => 'A Agricultura de Precisão da Drakkar é prática, técnica e feita sob medida.<br>Desde 2006, ajudamos produtores a usarem melhor seus recursos,<br>com foco em resultados reais e solo equilibrado',
    'cta' => [
        'text' => 'Quer produtividade de verdade?<br>A gente te mostra o caminho',
        'url' => '#contato',
        'style' => 'primary',
        'classes' => ['hero-cta']
    ],
    'alignment' => 'right',
    'overlay' => true,
    'classes' => ['hero-expertise']
];

// Output using the unified component system
echo Drakkar_Components::hero_section($hero_config);
?>
