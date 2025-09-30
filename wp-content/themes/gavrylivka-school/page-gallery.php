<?php
/**
 * Template Name: Gallery
 * Description: Custom template for displaying a responsive image gallery.
 *
 * @package Gavrylivka_School
 */

get_header();
?>

	<?php gavrylivka_school_breadcrumbs(); ?>

	<main id="primary" class="site-main gallery-page">
		<?php
		while ( have_posts() ) :
			the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class('gallery-article'); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header>

			<div class="entry-content">
				<?php
				// Output the content so editors can add intro text or Gutenberg/ACF blocks.
				the_content();
				?>

				<?php
				// If the editor inserts gallery blocks or a shortcode, they render via content above.
				// Optionally, render attached images as a fallback simple gallery when no blocks present.
				$has_gallery = has_block( 'gallery' ) || has_shortcode( get_the_content(), 'gallery' );
				if ( ! $has_gallery ) {
					$images = get_attached_media( 'image', get_the_ID() );
					if ( ! empty( $images ) ) :
						echo '<div class="gallery-grid" data-fallback="true">';
						foreach ( $images as $image ) {
							$thumb = wp_get_attachment_image_src( $image->ID, 'medium_large' );
							$full  = wp_get_attachment_image_src( $image->ID, 'full' );
							$alt   = get_post_meta( $image->ID, '_wp_attachment_image_alt', true );
							?>
							<a class="gallery-item" href="<?php echo esc_url( $full[0] ); ?>" data-lightbox="gallery">
								<img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" />
							</a>
							<?php
						}
						echo '</div>';
					endif;
				}
				?>
			</div>
		</article>

		<?php
		endwhile; // End of the loop.
		?>
	</main>

<?php
get_footer();
?>
