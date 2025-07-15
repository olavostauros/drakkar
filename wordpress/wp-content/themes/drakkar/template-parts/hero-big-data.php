<?php
/**
 * Hero Big Data Component
 *
 * Displays agricultural soil analysis data visualization dashboard
 * Features responsive bar chart, Portuguese interface, and dynamic data integration
 *
 * @package Drakkar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Default data configuration
$default_config = array(
    'title' => 'Big Data Drakkar',
    'subtitle' => 'Análise por Ciclo',
    'location' => 'Camada',
    'depth_range' => '00-10 cm',
    'sample_count' => '418.326,00',
    'cycle' => '1º Ciclo',
    'chart_data' => array(
        'fosforo' => 35,
        'potassio' => 15,
        'saturacao_bases' => 3
    ),
    'y_axis_max' => 70,
    'chart_labels' => array(
        'fosforo' => 'Fósforo',
        'potassio' => 'Potássio',
        'saturacao_bases' => 'Saturação de Bases'
    )
);

// Allow customization via filter
$big_data_config = apply_filters('drakkar_hero_big_data_config', $default_config);

// Sanitize data
$title = esc_html($big_data_config['title']);
$subtitle = esc_html($big_data_config['subtitle']);
$location = esc_html($big_data_config['location']);
$depth_range = esc_html($big_data_config['depth_range']);
$sample_count = esc_html($big_data_config['sample_count']);
$cycle = esc_html($big_data_config['cycle']);
$y_axis_max = intval($big_data_config['y_axis_max']);
$chart_data = $big_data_config['chart_data'];
$chart_labels = $big_data_config['chart_labels'];
?>

<section id="hero-big-data" class="hero-big-data-section">
    <div class="hero-big-data-container">

        <!-- Header Information -->
        <div class="hero-big-data-header">
            <div class="hero-big-data-info">
                <h1 class="hero-big-data-title"><?php echo $title; ?></h1>
                <h2 class="hero-big-data-subtitle"><?php echo $subtitle; ?></h2>

                <div class="hero-big-data-meta">
                    <div class="hero-big-data-meta-item">
                        <span class="hero-big-data-meta-label"><?php echo $location; ?></span>
                        <span class="hero-big-data-meta-value"><?php echo $depth_range; ?></span>
                    </div>
                    <div class="hero-big-data-meta-item">
                        <span class="hero-big-data-meta-label">Nº de amostras</span>
                        <span class="hero-big-data-meta-value"><?php echo $sample_count; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="hero-big-data-chart-container">
            <div class="hero-big-data-chart-header">
                <h3 class="hero-big-data-chart-title"><?php echo $cycle; ?></h3>
            </div>

            <div class="hero-big-data-chart">
                <!-- Y-axis labels -->
                <div class="hero-big-data-chart-y-axis">
                    <?php for ($i = $y_axis_max; $i >= 0; $i -= 10): ?>
                        <div class="hero-big-data-y-axis-label"><?php echo $i; ?></div>
                    <?php endfor; ?>
                </div>

                <!-- Chart area -->
                <div class="hero-big-data-chart-area">
                    <!-- Grid lines -->
                    <div class="hero-big-data-chart-grid">
                        <?php for ($i = 0; $i <= $y_axis_max; $i += 10): ?>
                            <div class="hero-big-data-grid-line" style="bottom: <?php echo ($i / $y_axis_max) * 100; ?>%;"></div>
                        <?php endfor; ?>
                    </div>

                    <!-- Data bars -->
                    <div class="hero-big-data-chart-bars">
                        <?php foreach ($chart_data as $key => $value): ?>
                            <?php
                                $height_percentage = ($value / $y_axis_max) * 100;
                                $label = isset($chart_labels[$key]) ? $chart_labels[$key] : ucfirst($key);
                            ?>
                            <div class="hero-big-data-bar-container">
                                <div class="hero-big-data-bar"
                                     style="height: <?php echo $height_percentage; ?>%;"
                                     data-value="<?php echo esc_attr($value); ?>"
                                     data-label="<?php echo esc_attr($label); ?>">
                                    <div class="hero-big-data-bar-value"><?php echo $value; ?></div>
                                </div>
                                <div class="hero-big-data-bar-label"><?php echo esc_html($label); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Big Data Styles */
.hero-big-data-section {
    padding: 60px 20px;
    background: linear-gradient(135deg, #f8fffe 0%, #e8f9f7 100%);
    min-height: 600px;
    display: flex;
    align-items: center;
}

.hero-big-data-container {
    max-width: 1200px;
    margin: 0 auto;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 60px;
    align-items: center;
}

/* Header Styles */
.hero-big-data-header {
    padding: 20px 0;
}

.hero-big-data-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin: 0 0 10px 0;
    line-height: 1.2;
}

.hero-big-data-subtitle {
    font-size: 1.5rem;
    font-weight: 400;
    color: #34495e;
    margin: 0 0 30px 0;
}

.hero-big-data-meta {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.hero-big-data-meta-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 15px;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
    border-left: 4px solid #4dd0e1;
}

.hero-big-data-meta-label {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.95rem;
}

.hero-big-data-meta-value {
    font-weight: 700;
    color: #4dd0e1;
    font-size: 1.1rem;
}

/* Chart Styles */
.hero-big-data-chart-container {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(77, 208, 225, 0.2);
}

.hero-big-data-chart-header {
    margin-bottom: 20px;
    text-align: center;
}

.hero-big-data-chart-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #4dd0e1;
    margin: 0;
    padding: 8px 16px;
    background: rgba(77, 208, 225, 0.1);
    border-radius: 6px;
    display: inline-block;
}

.hero-big-data-chart {
    display: grid;
    grid-template-columns: 50px 1fr;
    gap: 20px;
    height: 350px;
}

/* Y-axis */
.hero-big-data-chart-y-axis {
    display: flex;
    flex-direction: column-reverse;
    justify-content: space-between;
    padding-top: 20px;
    padding-bottom: 40px;
}

.hero-big-data-y-axis-label {
    font-size: 0.85rem;
    color: #666;
    text-align: right;
    line-height: 1;
}

/* Chart area */
.hero-big-data-chart-area {
    position: relative;
    border-left: 2px solid #ddd;
    border-bottom: 2px solid #ddd;
}

.hero-big-data-chart-grid {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.hero-big-data-grid-line {
    position: absolute;
    left: 0;
    right: 0;
    height: 1px;
    background: rgba(221, 221, 221, 0.5);
}

/* Bars */
.hero-big-data-chart-bars {
    display: flex;
    align-items: flex-end;
    height: 100%;
    padding: 20px 20px 0 20px;
    gap: 30px;
}

.hero-big-data-bar-container {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
}

.hero-big-data-bar {
    width: 100%;
    max-width: 80px;
    background: linear-gradient(180deg, #4dd0e1 0%, #26a69a 100%);
    border-radius: 4px 4px 0 0;
    position: relative;
    transition: all 0.3s ease;
    min-height: 5px;
    margin-bottom: 10px;
}

.hero-big-data-bar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(77, 208, 225, 0.4);
}

.hero-big-data-bar-value {
    position: absolute;
    top: -25px;
    left: 50%;
    transform: translateX(-50%);
    font-weight: 600;
    font-size: 0.9rem;
    color: #2c3e50;
    white-space: nowrap;
}

.hero-big-data-bar-label {
    font-size: 0.85rem;
    color: #666;
    text-align: center;
    line-height: 1.2;
    margin-top: auto;
    padding-top: 8px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-big-data-container {
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .hero-big-data-title {
        font-size: 2rem;
    }

    .hero-big-data-subtitle {
        font-size: 1.2rem;
    }

    .hero-big-data-chart-container {
        padding: 20px;
    }

    .hero-big-data-chart {
        height: 300px;
        grid-template-columns: 40px 1fr;
        gap: 15px;
    }

    .hero-big-data-chart-bars {
        gap: 15px;
        padding: 15px 15px 0 15px;
    }

    .hero-big-data-bar {
        max-width: 60px;
    }

    .hero-big-data-bar-label {
        font-size: 0.75rem;
    }
}

@media (max-width: 480px) {
    .hero-big-data-section {
        padding: 40px 15px;
    }

    .hero-big-data-meta-item {
        flex-direction: column;
        text-align: center;
        gap: 5px;
    }

    .hero-big-data-chart-bars {
        gap: 10px;
        padding: 10px;
    }

    .hero-big-data-bar-label {
        font-size: 0.7rem;
    }
}

/* Animation Classes */
.hero-big-data-section.animate-in .hero-big-data-bar {
    animation: barGrowth 1s ease-out forwards;
    height: 0 !important;
}

@keyframes barGrowth {
    to {
        height: var(--target-height) !important;
    }
}

/* Accessibility */
@media (prefers-reduced-motion: reduce) {
    .hero-big-data-bar {
        transition: none;
    }

    .hero-big-data-section.animate-in .hero-big-data-bar {
        animation: none;
        height: var(--target-height) !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation on scroll or immediate load
    const section = document.getElementById('hero-big-data');
    if (section) {
        // Set CSS custom properties for animation
        const bars = section.querySelectorAll('.hero-big-data-bar');
        bars.forEach(bar => {
            const height = bar.style.height;
            bar.style.setProperty('--target-height', height);
        });

        // Trigger animation
        setTimeout(() => {
            section.classList.add('animate-in');
        }, 300);
    }

    // Add hover effects for accessibility
    const bars = document.querySelectorAll('.hero-big-data-bar');
    bars.forEach(bar => {
        bar.addEventListener('focus', function() {
            this.style.transform = 'translateY(-2px)';
        });

        bar.addEventListener('blur', function() {
            this.style.transform = '';
        });
    });
});
</script>
