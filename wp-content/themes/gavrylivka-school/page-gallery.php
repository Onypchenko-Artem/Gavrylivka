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
				
				// Если есть блок галереи (Gutenberg или shortcode), добавляем пагинацию
				if ( $has_gallery ) {
					// Get all images from content (shortcode gallery)
					$all_images = array();
					
					// Check for gallery shortcode first
					if ( has_shortcode( get_the_content(), 'gallery' ) ) {
						// Parse gallery shortcode to get image IDs
						$content = get_the_content();
						if ( preg_match_all( '/\[gallery[^\]]*ids="([^"]*)"[^\]]*\]/', $content, $matches ) ) {
							foreach ( $matches[1] as $ids_string ) {
								$ids = explode( ',', $ids_string );
								foreach ( $ids as $id ) {
									$id = trim( $id );
									if ( is_numeric( $id ) ) {
										$image = get_post( $id );
										if ( $image && $image->post_type === 'attachment' ) {
											$all_images[] = $image;
										}
									}
								}
							}
						}
					}
					
					// If no shortcode gallery found, try Gutenberg blocks
					if ( empty( $all_images ) ) {
						$blocks = parse_blocks( get_the_content() );
						foreach ( $blocks as $block ) {
							if ( $block['blockName'] === 'core/gallery' ) {
								if ( isset( $block['attrs']['ids'] ) && is_array( $block['attrs']['ids'] ) ) {
									foreach ( $block['attrs']['ids'] as $image_id ) {
										$image = get_post( $image_id );
										if ( $image && $image->post_type === 'attachment' ) {
											$all_images[] = $image;
										}
									}
								}
							}
						}
					}
					
				// Fallback to attached media if no gallery found
				if ( empty( $all_images ) ) {
					$all_images = get_attached_media( 'image', get_the_ID() );
				}
				
				// Sort images by date (newest first)
				if ( ! empty( $all_images ) ) {
					usort( $all_images, function( $a, $b ) {
						return strtotime( $b->post_date ) - strtotime( $a->post_date );
					});
				}
				
				
				if ( ! empty( $all_images ) && count($all_images) > 20 ) {
						// Pagination setup for Gutenberg gallery
						$images_per_page = 20;
						$total_images = count( $all_images );
						$total_pages = ceil( $total_images / $images_per_page );
						$current_page = isset( $_GET['gallery_page'] ) ? max( 1, intval( $_GET['gallery_page'] ) ) : 1;
						$current_page = min( $current_page, $total_pages );
						
						// Calculate offset
						$offset = ( $current_page - 1 ) * $images_per_page;
						
						// Get images for current page
						$images = array_slice( $all_images, $offset, $images_per_page );
						
						
						// Hide original gallery and show paginated version
						echo '<style>
							.wp-block-gallery { display: none !important; }
							.gallery { display: none !important; }
							.wp-block-image { display: none !important; }
						</style>';
						
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
						
						// Show pagination info
						echo '<div class="gallery-pagination-info">';
						echo '<p>Показано ' . count($images) . ' з ' . $total_images . ' фотографій';
						if ( $total_pages > 1 ) {
							echo ' (сторінка ' . $current_page . ' з ' . $total_pages . ')';
						}
						echo '</p>';
						echo '</div>';
						
						// Display pagination if there are multiple pages
						if ( $total_pages > 1 ) {
							echo '<nav class="pagination-wrapper" aria-label="Навігація по сторінках галереї">';
							echo '<ul class="pagination">';
							
							// Previous arrow
							if ( $current_page > 1 ) {
								$prev_url = add_query_arg( 'gallery_page', $current_page - 1 );
								echo '<li class="pagination-item">';
								echo '<a href="' . esc_url( $prev_url ) . '" class="pagination-link pagination-prev" aria-label="Попередня сторінка">‹</a>';
								echo '</li>';
							}
							
							// Page numbers
							for ( $i = 1; $i <= $total_pages; $i++ ) {
								echo '<li class="pagination-item">';
								if ( $i == $current_page ) {
									echo '<span class="pagination-link pagination-current" aria-current="page">' . $i . '</span>';
								} else {
									$page_url = add_query_arg( 'gallery_page', $i );
									echo '<a href="' . esc_url( $page_url ) . '" class="pagination-link">' . $i . '</a>';
								}
								echo '</li>';
							}
							
							// Next arrow
							if ( $current_page < $total_pages ) {
								$next_url = add_query_arg( 'gallery_page', $current_page + 1 );
								echo '<li class="pagination-item">';
								echo '<a href="' . esc_url( $next_url ) . '" class="pagination-link pagination-next" aria-label="Наступна сторінка">›</a>';
								echo '</li>';
							}
							
							echo '</ul>';
							echo '</nav>';
						}
					}
				}
				
			if ( ! $has_gallery ) {
				// Get all attached images
				$all_images = get_attached_media( 'image', get_the_ID() );
				
				// Sort images by date (newest first)
				if ( ! empty( $all_images ) ) {
					usort( $all_images, function( $a, $b ) {
						return strtotime( $b->post_date ) - strtotime( $a->post_date );
					});
				}
				
				if ( ! empty( $all_images ) ) :
						// Pagination setup
						$images_per_page = 20;
						$total_images = count( $all_images );
						$total_pages = ceil( $total_images / $images_per_page );
						$current_page = isset( $_GET['gallery_page'] ) ? max( 1, intval( $_GET['gallery_page'] ) ) : 1;
						$current_page = min( $current_page, $total_pages );
						
						// Calculate offset
						$offset = ( $current_page - 1 ) * $images_per_page;
						
						// Get images for current page
						$images = array_slice( $all_images, $offset, $images_per_page );
						
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
						
						// Always show pagination info
						echo '<div class="gallery-pagination-info">';
						echo '<p>Показано ' . count($images) . ' з ' . $total_images . ' фотографій';
						if ( $total_pages > 1 ) {
							echo ' (сторінка ' . $current_page . ' з ' . $total_pages . ')';
						}
						echo '</p>';
						echo '</div>';
						
						// Display pagination if there are multiple pages
						if ( $total_pages > 1 ) {
							// Simple pagination
							echo '<nav class="pagination-wrapper" aria-label="Навігація по сторінках галереї">';
							echo '<ul class="pagination">';
							
							// Previous arrow
							if ( $current_page > 1 ) {
								$prev_url = add_query_arg( 'gallery_page', $current_page - 1 );
								echo '<li class="pagination-item">';
								echo '<a href="' . esc_url( $prev_url ) . '" class="pagination-link pagination-prev" aria-label="Попередня сторінка">‹</a>';
								echo '</li>';
							}
							
							// Page numbers
							for ( $i = 1; $i <= $total_pages; $i++ ) {
								echo '<li class="pagination-item">';
								if ( $i == $current_page ) {
									echo '<span class="pagination-link pagination-current" aria-current="page">' . $i . '</span>';
								} else {
									$page_url = add_query_arg( 'gallery_page', $i );
									echo '<a href="' . esc_url( $page_url ) . '" class="pagination-link">' . $i . '</a>';
								}
								echo '</li>';
							}
							
							// Next arrow
							if ( $current_page < $total_pages ) {
								$next_url = add_query_arg( 'gallery_page', $current_page + 1 );
								echo '<li class="pagination-item">';
								echo '<a href="' . esc_url( $next_url ) . '" class="pagination-link pagination-next" aria-label="Наступна сторінка">›</a>';
								echo '</li>';
							}
							
							echo '</ul>';
							echo '</nav>';
						}
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
