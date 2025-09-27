<?php
/**
 *
 * Template Name: Головна
 * Template Post Type: page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Gavrylivka_School
 */

get_header();
?>

<main id="primary" class="site-main home-page">
	
	<?php
	get_template_part('template-parts/home/hero-section');
	get_template_part('template-parts/home/about-section');
	get_template_part('template-parts/home/news-section');
	?>

</main>

<?php
get_footer();