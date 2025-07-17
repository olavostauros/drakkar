<?php

/**
 * Front Page Template
 *
 * Template for the front page (homepage) of the Drakkar website
 * Features hero section and statistics as the main landing area
 *
 * @package Drakkar
 */

get_header();
?>

<!-- Hero Section -->
<?php get_template_part('template-parts/hero-main'); ?>

<!-- Statistics Section -->
<?php get_template_part('template-parts/hero-statistics'); ?>

<!-- Hero Expertise Section -->
<?php get_template_part('template-parts/hero-expertise'); ?>

<!-- Hero Big Data Section -->
<?php get_template_part('template-parts/hero-big-data'); ?>

<!-- Hero Success History Section -->
<?php get_template_part('template-parts/hero-success-history'); ?>

<?php
get_footer();
?>
