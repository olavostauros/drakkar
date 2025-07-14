<?php

/**
 * Agriculture Section Component
 * 
 * About section showcasing Drakkar's precision agriculture expertise
 * Features company history, mission, and agricultural solutions
 * 
 * @package Drakkar
 */

// Get the background image URL
$agriculture_bg = get_template_directory_uri() . '/../../hero-media/section-agriculture.png';
?>

<section class="section-agriculture" style="background-image: url('<?php echo esc_url($agriculture_bg); ?>');">
	<div class="agriculture-background"></div>
	<div class="agriculture-content">
		<span class="agriculture-badge">Agricultura de Precisão</span>
		<h1 class="agriculture-title">
			Há 19 anos transformamos<br>
			<span class="text-accent">solo em estratégia</span>
		</h1>
		<p class="hero-description">
			A Agricultura de Precisão da Drakkar é prática, técnica e feita sob medida.<br>
			Desde 2006, ajudamos produtores a usarem melhor seus recursos,<br>
			com foco em resultados reais e solo equilibrado
		</p>
		<a href="#contato" class="hero-cta">
			Quer produtividade de verdade?<br>
			A gente te mostra o caminho
		</a>
	</div>
</section>

<style>
	.section-agriculture {
		position: relative;
		min-height: 100vh;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		display: flex;
		align-items: center;
		overflow: hidden;
	}

	.agriculture-background {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0, 0, 0, 0.4);
		z-index: 1;
	}

	.agriculture-content {
		position: relative;
		z-index: 2;
		max-width: 1200px;
		margin: 0 auto;
		padding: 0 20px;
		width: 100%;
		display: flex;
		flex-direction: column;
		align-items: flex-end;
		text-align: right;
	}

	.agriculture-badge {
		background-color: #C53E3E;
		color: #FFFFFF;
		padding: 8px 16px;
		border-radius: 20px;
		font-size: 14px;
		font-weight: 600;
		margin-bottom: 20px;
		display: inline-block;
	}

	.agriculture-title {
		font-size: 3.5rem;
		font-weight: bold;
		color: #FFFFFF;
		line-height: 1.2;
		margin-bottom: 30px;
		max-width: 600px;
	}

	.agriculture-title .text-accent {
		color: #C53E3E;
	}

	.hero-description {
		font-size: 1.2rem;
		color: #F5F5F5;
		line-height: 1.6;
		margin-bottom: 40px;
		max-width: 600px;
		font-weight: 400;
	}

	.hero-cta {
		background-color: #C53E3E;
		color: #FFFFFF;
		padding: 16px 32px;
		border-radius: 8px;
		text-decoration: none;
		font-size: 1.1rem;
		font-weight: 600;
		line-height: 1.4;
		transition: all 0.3s ease;
		display: inline-block;
		text-align: center;
	}

	.hero-cta:hover {
		background-color: #A73333;
		transform: translateY(-2px);
		box-shadow: 0 4px 15px rgba(197, 62, 62, 0.3);
		color: #FFFFFF;
		text-decoration: none;
	}

	/* Responsive Design */
	@media (max-width: 1024px) {
		.agriculture-content {
			align-items: center;
			text-align: center;
			max-width: 70%;
		}

		.agriculture-title {
			font-size: 3rem;
		}
	}

	@media (max-width: 768px) {
		.agriculture-content {
			max-width: 100%;
			padding: 0 30px;
		}

		.agriculture-title {
			font-size: 2.5rem;
		}

		.hero-description {
			font-size: 1.1rem;
		}

		.hero-cta {
			padding: 14px 28px;
			font-size: 1rem;
		}
	}

	@media (max-width: 480px) {
		.section-agriculture {
			min-height: 80vh;
		}

		.agriculture-title {
			font-size: 2rem;
			margin-bottom: 20px;
		}

		.hero-description {
			font-size: 1rem;
			margin-bottom: 30px;
		}

		.agriculture-badge {
			font-size: 12px;
			padding: 6px 12px;
			margin-bottom: 15px;
		}
	}

	/* Accessibility Improvements */
	.hero-cta:focus {
		outline: 3px solid #FFFFFF;
		outline-offset: 2px;
	}

	/* Performance: Prevent layout shift */
	.section-agriculture::before {
		content: '';
		display: block;
		padding-top: 56.25%;
		/* 16:9 aspect ratio fallback */
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		z-index: -1;
	}

	@media (min-width: 768px) {
		.section-agriculture::before {
			padding-top: 0;
			height: 100vh;
		}
	}
</style>