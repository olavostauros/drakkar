<?php
/**
 * Video presentation for the home page
 * @package Drakkar
 */
?>

<video class="home-video" autoplay loop muted playsinline>
    <source src="https://res.cloudinary.com/dnlxvrf5u/video/upload/v1752600890/output1_usqhmx.mp4" type="video/mp4">
    <p><?php esc_html_e('Your browser does not support the video tag.', 'drakkar'); ?></p>
</video>

<style>
.home-video {
    width: 100%;
    height: auto;
    display: block;
}
</style>
