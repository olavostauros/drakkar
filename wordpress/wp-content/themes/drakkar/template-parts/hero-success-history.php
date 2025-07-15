<?php
/**
 * Hero Success History Component
 *
 * Displays timeline of Drakkar's agricultural consulting success stories
 * Features interactive timeline, case studies, testimonials, and achievement metrics
 *
 * @package Drakkar
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Default success stories configuration
$default_config = array(
    'title' => 'Histórias de Sucesso',
    'subtitle' => 'Transformando a agricultura brasileira há mais de uma década',
    'timeline_orientation' => 'horizontal',
    'stories' => array(
        array(
            'id' => 'story-2024-01',
            'date' => '2024-01-15',
            'year' => '2024',
            'title' => 'Fazenda São José - Aumento de 35% na Produtividade',
            'location' => 'Mato Grosso',
            'category' => 'case-study',
            'summary' => 'Implementação de agricultura de precisão resultou em aumento significativo de produtividade de soja.',
            'details' => 'Através da análise detalhada do solo e aplicação de tecnologia de precisão, conseguimos otimizar o uso de fertilizantes e aumentar a produtividade em 35%. O projeto envolveu mapeamento completo da fazenda e aplicação variável de insumos.',
            'metrics' => array(
                'productivity_increase' => '35%',
                'area_covered' => '2.500 hectares',
                'roi' => '300%'
            ),
            'testimonial' => array(
                'quote' => 'A Drakkar revolucionou nossa fazenda. Em apenas uma safra, conseguimos resultados que não imaginávamos ser possíveis.',
                'author' => 'João Silva',
                'position' => 'Proprietário da Fazenda São José'
            ),
            'featured' => true
        ),
        array(
            'id' => 'story-2023-02',
            'date' => '2023-08-20',
            'year' => '2023',
            'title' => 'Cooperativa Agro Sul - Redução de 40% nos Custos',
            'location' => 'Rio Grande do Sul',
            'category' => 'case-study',
            'summary' => 'Otimização do uso de fertilizantes através de análise precisa do solo.',
            'details' => 'Projeto piloto com 15 produtores da cooperativa demonstrou redução significativa nos custos de produção através do uso racional de fertilizantes baseado em análises detalhadas.',
            'metrics' => array(
                'cost_reduction' => '40%',
                'producers_involved' => '15',
                'area_covered' => '1.800 hectares'
            ),
            'testimonial' => array(
                'quote' => 'O trabalho da Drakkar nos permitiu reduzir custos sem comprometer a produtividade.',
                'author' => 'Maria Santos',
                'position' => 'Presidente da Cooperativa Agro Sul'
            ),
            'featured' => false
        ),
        array(
            'id' => 'story-2023-01',
            'date' => '2023-03-10',
            'year' => '2023',
            'title' => 'Fazenda Esperança - Recuperação de Solos Degradados',
            'location' => 'Goiás',
            'category' => 'sustainability',
            'summary' => 'Programa de recuperação trouxe solos degradados de volta à produtividade.',
            'details' => 'Implementação de programa de correção e recuperação de solos que estavam com baixa fertilidade há mais de 10 anos, resultando em completa revitalização da área.',
            'metrics' => array(
                'soil_improvement' => '85%',
                'area_recovered' => '800 hectares',
                'time_frame' => '18 meses'
            ),
            'testimonial' => array(
                'quote' => 'Conseguimos recuperar terras que considerávamos perdidas. Foi um milagre da ciência.',
                'author' => 'Carlos Oliveira',
                'position' => 'Engenheiro Agrônomo'
            ),
            'featured' => false
        ),
        array(
            'id' => 'story-2022-01',
            'date' => '2022-11-05',
            'year' => '2022',
            'title' => 'Grupo Agropecuário Delta - Expansão Sustentável',
            'location' => 'Mato Grosso do Sul',
            'category' => 'expansion',
            'summary' => 'Planejamento estratégico permitiu expansão responsável de 5.000 hectares.',
            'details' => 'Desenvolvimento de plano de expansão baseado em análise completa do solo e potencial produtivo, garantindo sustentabilidade ambiental e econômica.',
            'metrics' => array(
                'expansion_area' => '5.000 hectares',
                'efficiency_gain' => '45%',
                'environmental_score' => '95%'
            ),
            'testimonial' => array(
                'quote' => 'A Drakkar nos deu a confiança necessária para expandir de forma responsável e lucrativa.',
                'author' => 'Ana Paula Costa',
                'position' => 'Diretora do Grupo Delta'
            ),
            'featured' => true
        )
    ),
    'display_options' => array(
        'show_metrics' => true,
        'show_testimonials' => true,
        'max_stories_displayed' => 10,
        'enable_filtering' => true
    )
);

// Allow customization via filter
$success_config = apply_filters('drakkar_hero_success_history_config', $default_config);

// Sanitize data
$title = esc_html($success_config['title']);
$subtitle = esc_html($success_config['subtitle']);
$timeline_orientation = esc_attr($success_config['timeline_orientation']);
$stories = $success_config['stories'];
$display_options = $success_config['display_options'];

// Sort stories by date (newest first)
usort($stories, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>

<section class="hero-success-history" id="historias-sucesso">
    <div class="container">
        <!-- Header Section -->
        <header class="success-header">
            <h2 class="success-title"><?php echo $title; ?></h2>
            <p class="success-subtitle"><?php echo $subtitle; ?></p>
        </header>

        <!-- Timeline Container -->
        <div class="success-timeline <?php echo esc_attr($timeline_orientation); ?>">
            <div class="timeline-container">
                <!-- Timeline Line -->
                <div class="timeline-line" aria-hidden="true"></div>

                <!-- Success Stories -->
                <div class="timeline-stories">
                    <?php foreach ($stories as $index => $story): ?>
                        <?php
                        // Sanitize story data
                        $story_id = esc_attr($story['id']);
                        $story_date = esc_html($story['date']);
                        $story_year = esc_html($story['year']);
                        $story_title = esc_html($story['title']);
                        $story_location = esc_html($story['location']);
                        $story_category = esc_attr($story['category']);
                        $story_summary = esc_html($story['summary']);
                        $story_details = esc_html($story['details']);
                        $is_featured = !empty($story['featured']);
                        $position_class = ($index % 2 === 0) ? 'timeline-left' : 'timeline-right';
                        ?>

                        <article class="story-milestone <?php echo $position_class; ?> <?php echo $is_featured ? 'featured' : ''; ?>"
                                 data-story-id="<?php echo $story_id; ?>"
                                 data-category="<?php echo $story_category; ?>"
                                 data-year="<?php echo $story_year; ?>">

                            <!-- Timeline Marker -->
                            <div class="timeline-marker" aria-hidden="true">
                                <span class="marker-year"><?php echo $story_year; ?></span>
                            </div>

                            <!-- Story Card -->
                            <div class="story-card">
                                <header class="story-header">
                                    <div class="story-meta">
                                        <time class="story-date" datetime="<?php echo esc_attr($story['date']); ?>">
                                            <?php echo date_i18n('j \d\e F \d\e Y', strtotime($story['date'])); ?>
                                        </time>
                                        <span class="story-location"><?php echo $story_location; ?></span>
                                    </div>
                                    <h3 class="story-title"><?php echo $story_title; ?></h3>
                                </header>

                                <div class="story-content">
                                    <p class="story-summary"><?php echo $story_summary; ?></p>

                                    <?php if ($display_options['show_metrics'] && !empty($story['metrics'])): ?>
                                        <div class="story-metrics">
                                            <h4 class="metrics-title">Resultados Alcançados:</h4>
                                            <ul class="metrics-list">
                                                <?php foreach ($story['metrics'] as $metric_key => $metric_value): ?>
                                                    <li class="metric-item">
                                                        <span class="metric-label"><?php echo esc_html(ucfirst(str_replace('_', ' ', $metric_key))); ?>:</span>
                                                        <strong class="metric-value"><?php echo esc_html($metric_value); ?></strong>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <button class="story-expand-btn"
                                            data-target="<?php echo $story_id; ?>-details"
                                            aria-expanded="false"
                                            aria-controls="<?php echo $story_id; ?>-details">
                                        Ver Mais Detalhes
                                        <span class="expand-icon" aria-hidden="true">+</span>
                                    </button>
                                </div>

                                <!-- Expandable Details -->
                                <div class="story-details" id="<?php echo $story_id; ?>-details" aria-hidden="true">
                                    <div class="details-content">
                                        <p class="story-full-description"><?php echo $story_details; ?></p>

                                        <?php if ($display_options['show_testimonials'] && !empty($story['testimonial'])): ?>
                                            <blockquote class="story-testimonial">
                                                <p class="testimonial-quote">"<?php echo esc_html($story['testimonial']['quote']); ?>"</p>
                                                <footer class="testimonial-author">
                                                    <cite class="author-name"><?php echo esc_html($story['testimonial']['author']); ?></cite>
                                                    <span class="author-position"><?php echo esc_html($story['testimonial']['position']); ?></span>
                                                </footer>
                                            </blockquote>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Timeline Navigation -->
        <?php if ($display_options['enable_filtering']): ?>
            <nav class="timeline-navigation" aria-label="Filtros da linha do tempo">
                <div class="timeline-filters">
                    <button class="filter-btn active" data-filter="all">Todas as Histórias</button>
                    <button class="filter-btn" data-filter="case-study">Casos de Estudo</button>
                    <button class="filter-btn" data-filter="sustainability">Sustentabilidade</button>
                    <button class="filter-btn" data-filter="expansion">Expansão</button>
                </div>
            </nav>
        <?php endif; ?>
    </div>
</section>

<!-- Component Styles -->
<style>
.hero-success-history {
    padding: 80px 0;
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.4)), url('<?php echo drakkar_get_image_url('backgrounds/hero-success-history.png'); ?>');
    background-size: cover;
    background-position: center center;
    background-attachment: fixed;
    position: relative;
    overflow: hidden;
    color: white;
}

.success-header {
    text-align: center;
    margin-bottom: 60px;
}

.success-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 16px;
    line-height: 1.2;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
}

.success-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.9);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.6;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
}

.success-timeline {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
}

.timeline-container {
    position: relative;
    padding: 40px 0;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 20px;
    backdrop-filter: blur(10px);
    margin: 40px 0;
}

.timeline-line {
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #007bff, #28a745);
    transform: translateX(-50%);
    border-radius: 2px;
}

.timeline-stories {
    position: relative;
}

.story-milestone {
    position: relative;
    margin-bottom: 80px;
    display: flex;
    align-items: center;
}

.story-milestone.timeline-left {
    flex-direction: row;
}

.story-milestone.timeline-right {
    flex-direction: row-reverse;
}

.timeline-marker {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 60px;
    background: #007bff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    z-index: 2;
}

.story-milestone.featured .timeline-marker {
    background: #28a745;
    width: 80px;
    height: 80px;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
}

.marker-year {
    color: white;
    font-weight: 700;
    font-size: 0.9rem;
}

.story-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    width: calc(50% - 60px);
    margin: 0 30px;
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.story-milestone.timeline-left .story-card {
    margin-right: auto;
}

.story-milestone.timeline-right .story-card {
    margin-left: auto;
}

.story-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
}

.story-milestone.featured .story-card {
    border: 2px solid #28a745;
    background: linear-gradient(135deg, #ffffff 0%, #f8fff9 100%);
}

.story-header {
    margin-bottom: 20px;
}

.story-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 0.9rem;
    color: #6c757d;
}

.story-date {
    font-weight: 500;
}

.story-location {
    background: #e3f2fd;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    color: #1976d2;
}

.story-title {
    font-size: 1.4rem;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.3;
    margin: 0;
}

.story-summary {
    color: #495057;
    line-height: 1.6;
    margin-bottom: 20px;
}

.story-metrics {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
}

.metrics-title {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 12px;
}

.metrics-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
}

.metric-item {
    display: flex;
    flex-direction: column;
}

.metric-label {
    font-size: 0.85rem;
    color: #6c757d;
    text-transform: capitalize;
}

.metric-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: #007bff;
}

.story-expand-btn {
    background: #007bff;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.story-expand-btn:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.expand-icon {
    transition: transform 0.3s ease;
}

.story-expand-btn[aria-expanded="true"] .expand-icon {
    transform: rotate(45deg);
}

.story-details {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
    display: none;
}

.story-details[aria-hidden="false"] {
    display: block;
    animation: fadeInDown 0.3s ease;
}

.story-testimonial {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 8px;
    border-left: 4px solid #28a745;
    margin: 20px 0 0 0;
    font-style: italic;
}

.testimonial-quote {
    font-size: 1.1rem;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.6;
}

.testimonial-author {
    text-align: right;
}

.author-name {
    font-weight: 600;
    color: #2c3e50;
    font-style: normal;
}

.author-position {
    display: block;
    font-size: 0.9rem;
    color: #6c757d;
    margin-top: 4px;
    font-style: normal;
}

.timeline-navigation {
    margin-top: 60px;
    text-align: center;
    background: rgba(255, 255, 255, 0.1);
    padding: 30px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.timeline-filters {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.filter-btn {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(255, 255, 255, 0.3);
    padding: 12px 24px;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 500;
    color: #2c3e50;
    transition: all 0.3s ease;
    backdrop-filter: blur(5px);
}

.filter-btn:hover,
.filter-btn.active {
    background: #007bff;
    border-color: #007bff;
    color: white;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-success-history {
        padding: 60px 0;
        background-attachment: scroll;
        background-size: cover;
        background-position: center center;
    }

    .success-title {
        font-size: 2rem;
    }

    .success-subtitle {
        font-size: 1.1rem;
    }

    .timeline-line {
        left: 30px;
    }

    .story-milestone {
        flex-direction: column;
        align-items: flex-start;
        margin-bottom: 50px;
    }

    .story-milestone.timeline-left,
    .story-milestone.timeline-right {
        flex-direction: column;
    }

    .timeline-marker {
        left: 30px;
        transform: translateX(-50%);
        width: 50px;
        height: 50px;
    }

    .story-milestone.featured .timeline-marker {
        width: 60px;
        height: 60px;
    }

    .story-card {
        width: calc(100% - 80px);
        margin-left: 80px;
        margin-right: 0;
    }

    .story-milestone.timeline-left .story-card,
    .story-milestone.timeline-right .story-card {
        margin-left: 80px;
        margin-right: 0;
    }

    .metrics-list {
        grid-template-columns: 1fr;
    }

    .timeline-filters {
        flex-direction: column;
        align-items: center;
    }

    .filter-btn {
        width: 200px;
    }
}

@media (max-width: 480px) {
    .story-card {
        width: calc(100% - 60px);
        margin-left: 60px;
        padding: 20px;
    }

    .story-milestone.timeline-left .story-card,
    .story-milestone.timeline-right .story-card {
        margin-left: 60px;
    }

    .story-title {
        font-size: 1.2rem;
    }

    .timeline-marker {
        width: 40px;
        height: 40px;
    }

    .story-milestone.featured .timeline-marker {
        width: 50px;
        height: 50px;
    }
}
</style>

<!-- Component JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timeline interaction functionality
    const expandButtons = document.querySelectorAll('.story-expand-btn');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const storyMilestones = document.querySelectorAll('.story-milestone');

    // Handle story expansion
    expandButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const detailsElement = document.getElementById(targetId);
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            if (isExpanded) {
                // Collapse
                this.setAttribute('aria-expanded', 'false');
                detailsElement.setAttribute('aria-hidden', 'true');
                this.innerHTML = 'Ver Mais Detalhes <span class="expand-icon" aria-hidden="true">+</span>';
            } else {
                // Expand
                this.setAttribute('aria-expanded', 'true');
                detailsElement.setAttribute('aria-hidden', 'false');
                this.innerHTML = 'Ver Menos <span class="expand-icon" aria-hidden="true">+</span>';
            }
        });
    });

    // Handle filtering
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter stories
            storyMilestones.forEach(story => {
                const category = story.getAttribute('data-category');

                if (filter === 'all' || category === filter) {
                    story.style.display = 'flex';
                    story.style.animation = 'fadeInDown 0.5s ease';
                } else {
                    story.style.display = 'none';
                }
            });
        });
    });

    // Smooth scroll for timeline navigation
    const timelineSection = document.querySelector('.hero-success-history');
    if (timelineSection) {
        // Add scroll-triggered animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all story cards
        const storyCards = document.querySelectorAll('.story-card');
        storyCards.forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });
    }
});
</script>
