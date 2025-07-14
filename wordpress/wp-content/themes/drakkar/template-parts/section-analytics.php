<?php

/**
 * Analytics Section Component
 * 
 * Data visualization section displaying agricultural analytics dashboard
 * Features interactive charts and soil analysis data for precision agriculture
 * 
 * @package Drakkar
 */

// Data structure for the component
$big_data = array(
	'title' => 'Big Data Drakkar',
	'subtitle' => 'Análise por Ciclo',
	'metadata' => array(
		'location' => 'Camada',
		'depth' => '00-10 cm',
		'samples' => '418.326,00'
	),
	'chartData' => array(
		array('label' => 'Fósforo', 'value' => 35, 'unit' => ''),
		array('label' => 'Potássio', 'value' => 15, 'unit' => ''),
		array('label' => 'Saturação de Bases', 'value' => 4, 'unit' => '')
	)
);
?>

<section class="section-analytics" id="section-analytics" aria-labelledby="big-data-title">
	<div class="section-analytics-container">

		<!-- Header Section -->
		<header class="big-data-header">
			<h1 id="big-data-title" class="big-data-title"><?php echo esc_html($big_data['title']); ?></h1>
			<p class="big-data-subtitle"><?php echo esc_html($big_data['subtitle']); ?></p>
		</header>

		<!-- Metadata Section -->
		<div class="big-data-metadata">
			<div class="metadata-item">
				<span class="metadata-label">Local:</span>
				<span class="metadata-value"><?php echo esc_html($big_data['metadata']['location']); ?></span>
			</div>
			<div class="metadata-item">
				<span class="metadata-label">Profundidade:</span>
				<span class="metadata-value"><?php echo esc_html($big_data['metadata']['depth']); ?></span>
			</div>
			<div class="metadata-item">
				<span class="metadata-label">Nº de amostras:</span>
				<span class="metadata-value"><?php echo esc_html($big_data['metadata']['samples']); ?></span>
			</div>
		</div>

		<!-- Chart Section -->
		<div class="big-data-chart-container">
			<div class="chart-wrapper" role="img" aria-labelledby="chart-title" aria-describedby="chart-description">
				<h2 id="chart-title" class="visually-hidden">Gráfico de Análise de Solo</h2>
				<p id="chart-description" class="visually-hidden">
					Gráfico de barras mostrando níveis de Fósforo (35), Potássio (15) e Saturação de Bases (4) na análise de solo
				</p>

				<div class="chart-grid">
					<!-- Y-axis labels -->
					<div class="y-axis">
						<span class="y-label">40</span>
						<span class="y-label">30</span>
						<span class="y-label">20</span>
						<span class="y-label">10</span>
						<span class="y-label">0</span>
					</div>

					<!-- Chart bars -->
					<div class="chart-bars">
						<?php foreach ($big_data['chartData'] as $index => $data): ?>
							<div class="bar-container" data-delay="<?php echo $index * 200; ?>">
								<div class="bar"
									data-value="<?php echo esc_attr($data['value']); ?>"
									style="--bar-height: <?php echo ($data['value'] / 40) * 100; ?>%;"
									tabindex="0"
									role="button"
									aria-label="<?php echo esc_attr($data['label'] . ': ' . $data['value']); ?>">
									<div class="bar-fill"></div>
									<div class="bar-tooltip">
										<span class="tooltip-value"><?php echo esc_html($data['value']); ?></span>
										<span class="tooltip-label"><?php echo esc_html($data['label']); ?></span>
									</div>
								</div>
								<div class="bar-label"><?php echo esc_html($data['label']); ?></div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Loading State -->
		<div class="big-data-loading" aria-hidden="true">
			<div class="loading-spinner"></div>
			<p>Carregando dados...</p>
		</div>
	</div>
</section>

<style>
	/* CSS Custom Properties */
	:root {
		--color-primary: #2DD4BF;
		--color-primary-hover: #14B8A6;
		--color-text-primary: #374151;
		--color-text-secondary: #6B7280;
		--color-background: #FFFFFF;
		--color-background-light: #F9FAFB;
		--color-grid: #E5E7EB;
		--border-radius: 8px;
		--transition: all 0.3s ease;
		--shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
	}

	/* Main Hero Section */
	.section-analytics {
		position: relative;
		min-height: 100vh;
		background: linear-gradient(135deg, var(--color-background) 0%, var(--color-background-light) 100%);
		display: flex;
		align-items: center;
		padding: 60px 0;
		overflow: hidden;
	}

	.section-analytics-container {
		max-width: 1200px;
		margin: 0 auto;
		padding: 0 20px;
		width: 100%;
		position: relative;
	}

	/* Header Section */
	.big-data-header {
		text-align: center;
		margin-bottom: 40px;
	}

	.big-data-title {
		font-size: 3.5rem;
		font-weight: 700;
		color: var(--color-text-primary);
		margin-bottom: 16px;
		line-height: 1.2;
		text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
	}

	.big-data-subtitle {
		font-size: 1.5rem;
		color: var(--color-text-secondary);
		font-weight: 500;
		margin: 0;
	}

	/* Metadata Section */
	.big-data-metadata {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 20px;
		margin-bottom: 60px;
		padding: 30px;
		background: var(--color-background);
		border-radius: var(--border-radius);
		box-shadow: var(--shadow);
	}

	.metadata-item {
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		padding: 20px;
		border-radius: var(--border-radius);
		background: var(--color-background-light);
		transition: var(--transition);
	}

	.metadata-item:hover {
		transform: translateY(-2px);
		box-shadow: var(--shadow);
	}

	.metadata-label {
		font-size: 0.9rem;
		color: var(--color-text-secondary);
		font-weight: 500;
		margin-bottom: 8px;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}

	.metadata-value {
		font-size: 1.5rem;
		font-weight: 700;
		color: var(--color-text-primary);
		font-family: 'Courier New', monospace;
	}

	/* Chart Container */
	.big-data-chart-container {
		background: var(--color-background);
		border-radius: var(--border-radius);
		padding: 40px;
		box-shadow: var(--shadow);
		margin-bottom: 40px;
	}

	.chart-wrapper {
		position: relative;
		height: 400px;
		width: 100%;
	}

	.chart-grid {
		display: grid;
		grid-template-columns: 60px 1fr;
		height: 100%;
		gap: 20px;
	}

	/* Y-Axis */
	.y-axis {
		display: flex;
		flex-direction: column;
		justify-content: space-between;
		align-items: flex-end;
		padding-right: 10px;
		height: 100%;
	}

	.y-label {
		font-size: 0.875rem;
		color: var(--color-text-secondary);
		font-weight: 500;
		position: relative;
	}

	.y-label::after {
		content: '';
		position: absolute;
		left: 100%;
		top: 50%;
		transform: translateY(-50%);
		width: 10px;
		height: 1px;
		background: var(--color-grid);
		margin-left: 10px;
	}

	/* Chart Bars */
	.chart-bars {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 40px;
		align-items: end;
		height: 100%;
		position: relative;
	}

	.chart-bars::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-image:
			linear-gradient(to right, var(--color-grid) 1px, transparent 1px),
			linear-gradient(to top, var(--color-grid) 1px, transparent 1px);
		background-size: 100% 25%;
		opacity: 0.3;
		pointer-events: none;
	}

	.bar-container {
		position: relative;
		height: 100%;
		display: flex;
		flex-direction: column;
		align-items: center;
		opacity: 0;
		transform: translateY(20px);
		animation: slideInUp 0.6s ease forwards;
	}

	.bar-container[data-delay="0"] {
		animation-delay: 0.2s;
	}

	.bar-container[data-delay="200"] {
		animation-delay: 0.4s;
	}

	.bar-container[data-delay="400"] {
		animation-delay: 0.6s;
	}

	.bar {
		width: 60px;
		height: var(--bar-height);
		max-height: calc(100% - 40px);
		background: var(--color-primary);
		border-radius: var(--border-radius) var(--border-radius) 0 0;
		position: relative;
		cursor: pointer;
		transition: var(--transition);
		outline: none;
		overflow: hidden;
	}

	.bar-fill {
		width: 100%;
		height: 0;
		background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-hover) 100%);
		border-radius: var(--border-radius) var(--border-radius) 0 0;
		transition: height 1s ease;
		position: absolute;
		bottom: 0;
	}

	.bar:hover,
	.bar:focus {
		background: var(--color-primary-hover);
		transform: translateY(-4px);
		box-shadow: 0 8px 25px rgba(45, 212, 191, 0.3);
	}

	.bar:hover .bar-fill,
	.bar:focus .bar-fill {
		height: 100%;
	}

	/* Tooltips */
	.bar-tooltip {
		position: absolute;
		bottom: 100%;
		left: 50%;
		transform: translateX(-50%) translateY(-10px);
		background: var(--color-text-primary);
		color: white;
		padding: 8px 12px;
		border-radius: var(--border-radius);
		font-size: 0.875rem;
		white-space: nowrap;
		opacity: 0;
		pointer-events: none;
		transition: var(--transition);
		box-shadow: var(--shadow);
		z-index: 10;
	}

	.bar-tooltip::after {
		content: '';
		position: absolute;
		top: 100%;
		left: 50%;
		transform: translateX(-50%);
		border: 6px solid transparent;
		border-top-color: var(--color-text-primary);
	}

	.bar:hover .bar-tooltip,
	.bar:focus .bar-tooltip {
		opacity: 1;
		transform: translateX(-50%) translateY(-5px);
	}

	.tooltip-value {
		font-weight: 700;
		font-size: 1rem;
	}

	.tooltip-label {
		display: block;
		font-size: 0.75rem;
		opacity: 0.8;
		margin-top: 2px;
	}

	/* Bar Labels */
	.bar-label {
		margin-top: 16px;
		font-size: 0.875rem;
		font-weight: 500;
		color: var(--color-text-primary);
		text-align: center;
		max-width: 80px;
		line-height: 1.3;
	}

	/* Loading State */
	.big-data-loading {
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		text-align: center;
		opacity: 0;
		pointer-events: none;
		transition: var(--transition);
	}

	.big-data-loading.active {
		opacity: 1;
		pointer-events: all;
	}

	.loading-spinner {
		width: 40px;
		height: 40px;
		border: 4px solid var(--color-grid);
		border-top: 4px solid var(--color-primary);
		border-radius: 50%;
		animation: spin 1s linear infinite;
		margin: 0 auto 16px;
	}

	/* Accessibility */
	.visually-hidden {
		position: absolute;
		width: 1px;
		height: 1px;
		padding: 0;
		margin: -1px;
		overflow: hidden;
		clip: rect(0, 0, 0, 0);
		white-space: nowrap;
		border: 0;
	}

	/* Animations */
	@keyframes slideInUp {
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	/* Responsive Design */
	@media (max-width: 1024px) {
		.big-data-title {
			font-size: 3rem;
		}

		.big-data-chart-container {
			padding: 30px;
		}

		.chart-bars {
			gap: 30px;
		}

		.bar {
			width: 50px;
		}
	}

	@media (max-width: 768px) {
		.section-analytics {
			min-height: auto;
			padding: 40px 0;
		}

		.big-data-title {
			font-size: 2.5rem;
		}

		.big-data-subtitle {
			font-size: 1.25rem;
		}

		.big-data-metadata {
			grid-template-columns: 1fr;
			gap: 15px;
			padding: 20px;
			margin-bottom: 40px;
		}

		.metadata-item {
			padding: 15px;
		}

		.metadata-value {
			font-size: 1.25rem;
		}

		.big-data-chart-container {
			padding: 20px;
		}

		.chart-wrapper {
			height: 300px;
		}

		.chart-grid {
			grid-template-columns: 50px 1fr;
			gap: 15px;
		}

		.chart-bars {
			gap: 20px;
		}

		.bar {
			width: 40px;
		}

		.bar-label {
			font-size: 0.75rem;
			max-width: 60px;
		}
	}

	@media (max-width: 480px) {
		.section-analytics-container {
			padding: 0 15px;
		}

		.big-data-title {
			font-size: 2rem;
		}

		.big-data-subtitle {
			font-size: 1.125rem;
		}

		.big-data-metadata {
			padding: 15px;
		}

		.metadata-item {
			padding: 12px;
		}

		.metadata-value {
			font-size: 1.125rem;
		}

		.chart-wrapper {
			height: 250px;
		}

		.chart-bars {
			gap: 15px;
		}

		.bar {
			width: 35px;
		}

		.bar-label {
			font-size: 0.7rem;
			margin-top: 12px;
		}
	}

	/* High contrast mode support */
	@media (prefers-contrast: high) {
		.bar {
			border: 2px solid var(--color-text-primary);
		}

		.metadata-item {
			border: 1px solid var(--color-text-secondary);
		}
	}

	/* Reduced motion support */
	@media (prefers-reduced-motion: reduce) {
		.bar-container {
			animation: none;
			opacity: 1;
			transform: none;
		}

		.bar,
		.bar-tooltip,
		.metadata-item {
			transition: none;
		}

		.loading-spinner {
			animation: none;
		}
	}

	/* Print styles */
	@media print {
		.section-analytics {
			min-height: auto;
			background: white;
			color: black;
		}

		.bar-tooltip {
			position: static;
			opacity: 1;
			background: transparent;
			color: black;
			transform: none;
			margin-top: 5px;
		}

		.bar-tooltip::after {
			display: none;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const heroSection = document.querySelector('.section-analytics');
		const loadingElement = document.querySelector('.big-data-loading');
		const bars = document.querySelectorAll('.bar');
		const barFills = document.querySelectorAll('.bar-fill');

		// Initialize component
		function initializeBigDataHero() {
			// Hide loading state
			if (loadingElement) {
				loadingElement.style.display = 'none';
			}

			// Animate bars when they come into view
			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						animateBars();
						observer.unobserve(entry.target);
					}
				});
			}, {
				threshold: 0.3
			});

			if (heroSection) {
				observer.observe(heroSection);
			}
		}

		// Animate bar fills
		function animateBars() {
			barFills.forEach((fill, index) => {
				setTimeout(() => {
					fill.style.height = '100%';
				}, index * 200);
			});
		}

		// Add keyboard navigation for bars
		bars.forEach((bar, index) => {
			bar.addEventListener('keydown', function(e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					this.focus();

					// Announce value to screen readers
					const value = this.getAttribute('data-value');
					const label = this.parentElement.querySelector('.bar-label').textContent;

					// Create temporary announcement element
					const announcement = document.createElement('div');
					announcement.setAttribute('aria-live', 'polite');
					announcement.setAttribute('aria-atomic', 'true');
					announcement.className = 'visually-hidden';
					announcement.textContent = `${label}: ${value}`;

					document.body.appendChild(announcement);

					setTimeout(() => {
						document.body.removeChild(announcement);
					}, 1000);
				}

				// Arrow key navigation
				if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
					e.preventDefault();
					const direction = e.key === 'ArrowLeft' ? -1 : 1;
					const nextIndex = (index + direction + bars.length) % bars.length;
					bars[nextIndex].focus();
				}
			});
		});

		// Add hover effects for accessibility
		bars.forEach(bar => {
			bar.addEventListener('mouseenter', function() {
				this.setAttribute('aria-expanded', 'true');
			});

			bar.addEventListener('mouseleave', function() {
				this.setAttribute('aria-expanded', 'false');
			});
		});

		// Handle window resize for responsive behavior
		let resizeTimeout;
		window.addEventListener('resize', function() {
			clearTimeout(resizeTimeout);
			resizeTimeout = setTimeout(() => {
				// Recalculate chart dimensions if needed
				adjustChartForScreenSize();
			}, 250);
		});

		function adjustChartForScreenSize() {
			const screenWidth = window.innerWidth;
			const chartContainer = document.querySelector('.big-data-chart-container');

			if (chartContainer) {
				if (screenWidth < 480) {
					chartContainer.classList.add('mobile-chart');
				} else {
					chartContainer.classList.remove('mobile-chart');
				}
			}
		}

		// Error handling for missing elements
		function handleMissingElements() {
			if (!heroSection) {
				console.warn('Big Data Hero: Hero section not found');
				return false;
			}

			if (bars.length === 0) {
				console.warn('Big Data Hero: No chart bars found');
				return false;
			}

			return true;
		}

		// Initialize if all elements are present
		if (handleMissingElements()) {
			initializeBigDataHero();
		}

		// Expose API for external interaction
		window.DrrakkarBigDataHero = {
			animateBars: animateBars,
			resetAnimation: function() {
				barFills.forEach(fill => {
					fill.style.height = '0';
				});
			}
		};
	});
</script>