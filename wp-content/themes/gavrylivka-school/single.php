<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Gavrylivka_School
 */

get_header();
?>

	<?php gavrylivka_school_breadcrumbs(); ?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		
		// Related news section
		get_template_part( 'template-parts/single/related-news' );
		?>

	</main><!-- #main -->

<?php
get_footer();
